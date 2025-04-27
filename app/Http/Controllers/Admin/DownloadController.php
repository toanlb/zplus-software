<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Mail\DownloadLinkMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;

class DownloadController extends Controller
{
    /**
     * Display a listing of the downloads.
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $search = $request->get('search');
        
        $downloads = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select(
                'order_items.id',
                'order_items.download_link',
                'order_items.download_count',
                'order_items.downloaded_at',
                'products.name as product_name',
                'products.id as product_id',
                'orders.order_number',
                'users.name as user_name',
                'users.id as user_id'
            )
            ->when($filter === 'downloaded', function ($query) {
                return $query->whereNotNull('order_items.downloaded_at');
            })
            ->when($filter === 'not_downloaded', function ($query) {
                return $query->whereNull('order_items.downloaded_at');
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('products.name', 'like', "%{$search}%")
                      ->orWhere('users.name', 'like', "%{$search}%")
                      ->orWhere('users.email', 'like', "%{$search}%")
                      ->orWhere('orders.order_number', 'like', "%{$search}%");
                });
            })
            ->orderBy('order_items.downloaded_at', 'desc')
            ->paginate(15)
            ->withQueryString();
        
        // Thống kê tổng quan
        $stats = [
            'total' => DB::table('order_items')->whereNotNull('download_link')->count(),
            'downloaded' => DB::table('order_items')->whereNotNull('downloaded_at')->count(),
            'not_downloaded' => DB::table('order_items')
                ->whereNotNull('download_link')
                ->whereNull('downloaded_at')
                ->count(),
            'total_downloads' => DB::table('order_items')->sum('download_count')
        ];
        
        // Các sản phẩm phổ biến nhất
        $popularProducts = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select('products.name', DB::raw('SUM(order_items.download_count) as total_downloads'))
            ->whereNotNull('order_items.downloaded_at')
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_downloads', 'desc')
            ->limit(5)
            ->get();
            
        return view('admin.downloads.index', compact('downloads', 'stats', 'popularProducts', 'filter', 'search'));
    }
    
    /**
     * Display the statistics dashboard for downloads.
     */
    public function statistics()
    {
        // Thống kê theo thời gian (tháng hiện tại)
        $downloadsByDay = DB::table('order_items')
            ->select(DB::raw('DATE(downloaded_at) as date'), DB::raw('COUNT(*) as count'))
            ->whereNotNull('downloaded_at')
            ->whereMonth('downloaded_at', now()->month)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Thống kê số lượng tải xuống theo tháng (6 tháng gần đây)
        $downloadsByMonth = DB::table('order_items')
            ->select(DB::raw('YEAR(downloaded_at) as year'), DB::raw('MONTH(downloaded_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereNotNull('downloaded_at')
            ->where('downloaded_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Thống kê theo sản phẩm (10 sản phẩm hàng đầu)
        $downloadsByProduct = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select('products.name', DB::raw('SUM(order_items.download_count) as total_downloads'))
            ->whereNotNull('order_items.downloaded_at')
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_downloads', 'desc')
            ->limit(10)
            ->get();
            
        // Khách hàng tải xuống nhiều nhất (5 người dùng hàng đầu)
        $topUsers = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('users.id', 'users.name', 'users.email', DB::raw('SUM(order_items.download_count) as total_downloads'))
            ->whereNotNull('order_items.downloaded_at')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_downloads', 'desc')
            ->limit(5)
            ->get();
            
        // Tổng số lượt tải xuống
        $totalDownloads = DB::table('order_items')->sum('download_count');
        
        return view('admin.downloads.statistics', compact(
            'downloadsByDay', 
            'downloadsByMonth', 
            'downloadsByProduct', 
            'topUsers',
            'totalDownloads'
        ));
    }
    
    /**
     * Generate a new download link for an order item.
     */
    public function regenerateLink(OrderItem $orderItem)
    {
        // Tạo download token mới
        $token = md5(uniqid() . time() . $orderItem->id);
        
        // Lưu token mới vào database
        $orderItem->update([
            'download_token' => $token,
            'token_expires_at' => now()->addDays(7) // Token hết hạn sau 7 ngày
        ]);
        
        return redirect()->back()->with('success', 'Đã tạo link tải xuống mới thành công');
    }
    
    /**
     * Process a download request with token verification.
     */
    public function download($token)
    {
        // Middleware đã xác thực token và lưu orderItem vào request
        $orderItem = request()->attributes->get('orderItem');
        
        // Cập nhật thông tin tải xuống
        $orderItem->increment('download_count');
        $orderItem->downloaded_at = $orderItem->downloaded_at ?? now();
        $orderItem->save();
        
        // Tải file
        return Storage::disk('private')->download(
            $orderItem->download_link,
            // Tên file khi tải xuống
            basename($orderItem->download_link)
        );
    }
    
    /**
     * Show download tracking for a specific product.
     */
    public function productDownloads(Product $product)
    {
        $downloads = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select(
                'order_items.id',
                'order_items.download_count',
                'order_items.downloaded_at',
                'orders.order_number',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->where('order_items.product_id', $product->id)
            ->whereNotNull('order_items.downloaded_at')
            ->orderBy('order_items.downloaded_at', 'desc')
            ->paginate(15);
            
        // Thống kê tải xuống của sản phẩm
        $stats = [
            'total_downloads' => DB::table('order_items')
                ->where('product_id', $product->id)
                ->sum('download_count'),
            'unique_users' => DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('order_items.product_id', $product->id)
                ->whereNotNull('order_items.downloaded_at')
                ->distinct('orders.user_id')
                ->count('orders.user_id')
        ];
        
        return view('admin.downloads.product', compact('product', 'downloads', 'stats'));
    }

    /**
     * Request a new download link when the old one has expired.
     */
    public function requestNewLink($token)
    {
        // Tìm order item có token này
        $orderItem = OrderItem::where('download_token', $token)->first();
            
        if (!$orderItem) {
            abort(404, 'Link tải không tồn tại');
        }

        // Kiểm tra xem đơn hàng đã được thanh toán chưa
        if (!$orderItem->order || !in_array($orderItem->order->status, ['paid', 'completed'])) {
            return redirect()->back()->with('error', 'Không thể tạo lại link tải. Đơn hàng chưa được thanh toán.');
        }

        // Kiểm tra xem file có tồn tại không
        if (!$orderItem->download_link || !Storage::disk('private')->exists($orderItem->download_link)) {
            return redirect()->back()->with('error', 'File không tồn tại trong hệ thống.');
        }
        
        // Tạo lại download token
        $orderItem->generateDownloadToken();
        
        // Gửi email thông báo link mới
        $order = $orderItem->order;
        $downloadLinks = [[
            'product' => $orderItem->product->name,
            'url' => route('download', ['token' => $orderItem->download_token]),
            'expires_at' => $orderItem->token_expires_at
        ]];
        
        try {
            Mail::to($order->email ?? $order->user->email)
                ->send(new DownloadLinkMail($order, $downloadLinks, true));
            
            return view('download.new_link_sent');
        } catch (\Exception $e) {
            \Log::error('Không thể gửi lại email download link: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại sau.');
        }
    }
}
