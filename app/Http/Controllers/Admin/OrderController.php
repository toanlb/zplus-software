<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Mail\DownloadLinkMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of an order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,paid,completed,cancelled,refunded',
        ]);

        $order->status = $validated['status'];
        
        // Nếu đơn hàng được chuyển sang trạng thái đã thanh toán, cập nhật thời gian thanh toán
        if ($validated['status'] === 'paid' && !$order->paid_at) {
            $order->paid_at = now();
            
            // Tự động tạo download tokens cho các order items
            foreach ($order->items as $item) {
                if ($item->product->download_link) {
                    $item->generateDownloadToken();
                }
            }
            
            // Gửi email thông báo kèm các link tải
            $this->sendDownloadLinks($order);
        }
        
        $order->save();
        
        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }

    /**
     * Display order dashboard.
     */
    public function dashboard()
    {
        // Thống kê đơn hàng theo trạng thái
        $orderStats = DB::table('orders')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Tổng đơn hàng
        $totalOrders = Order::count();

        // Đơn hàng chờ xử lý
        $pendingOrders = $orderStats['pending'] ?? 0;

        // Đơn hàng đã hoàn tất
        $completedOrders = $orderStats['completed'] ?? 0;

        // Tổng doanh thu
        $totalRevenue = Order::where('status', 'paid')
            ->orWhere('status', 'completed')
            ->sum('total_price');

        // Doanh thu theo tháng (6 tháng gần nhất)
        $monthlySales = DB::table('orders')
            ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as total'))
            ->where(function($query) {
                $query->where('status', 'paid')
                      ->orWhere('status', 'completed');
            })
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Đơn hàng gần đây
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.orders.dashboard', compact(
            'orderStats', 
            'totalRevenue', 
            'totalOrders', 
            'pendingOrders', 
            'completedOrders', 
            'monthlySales',
            'recentOrders'
        ));
    }

    /**
     * Send download links for an order.
     */
    private function sendDownloadLinks(Order $order)
    {
        // Chỉ gửi link tải cho các đơn hàng đã thanh toán
        if ($order->status !== 'paid' && $order->status !== 'completed') {
            return;
        }

        $downloadLinks = [];
        
        foreach ($order->items as $item) {
            // Chỉ gửi link cho các sản phẩm có file tải xuống
            if ($item->product->download_link && $item->download_token) {
                $downloadLinks[] = [
                    'product' => $item->product->name,
                    'url' => route('download', ['token' => $item->download_token]),
                    'expires_at' => $item->token_expires_at
                ];
            }
        }
        
        if (count($downloadLinks) > 0) {
            try {
                Mail::to($order->email ?? $order->user->email)
                    ->send(new DownloadLinkMail($order, $downloadLinks));
                
                return true;
            } catch (\Exception $e) {
                \Log::error('Không thể gửi email download link: ' . $e->getMessage());
                return false;
            }
        }
        
        return false;
    }

    /**
     * Resend download link for an order item.
     */
    public function resendDownloadLink(OrderItem $orderItem)
    {
        $order = $orderItem->order;
        
        // Kiểm tra quyền truy cập
        if (!$order || ($order->status !== 'paid' && $order->status !== 'completed')) {
            return redirect()->back()->with('error', 'Không thể gửi lại link tải. Đơn hàng chưa được thanh toán.');
        }
        
        // Tạo lại download token nếu chưa có hoặc đã hết hạn
        if (!$orderItem->download_token || !$orderItem->isDownloadTokenValid()) {
            $orderItem->generateDownloadToken();
        }
        
        $downloadLinks = [[
            'product' => $orderItem->product->name,
            'url' => route('download', ['token' => $orderItem->download_token]),
            'expires_at' => $orderItem->token_expires_at
        ]];
        
        try {
            Mail::to($order->email ?? $order->user->email)
                ->send(new DownloadLinkMail($order, $downloadLinks, true));
            
            return redirect()->back()->with('success', 'Link tải đã được gửi lại thành công.');
        } catch (\Exception $e) {
            \Log::error('Không thể gửi lại email download link: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại sau.');
        }
    }
}