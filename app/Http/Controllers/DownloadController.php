<?php

namespace App\Http\Controllers;

use App\Mail\DownloadLinkMail;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Trang hiển thị khi link download hết hạn
     */
    public function expired(Request $request)
    {
        return view('download.expired');
    }
    
    /**
     * Xử lý tải xuống file
     */
    public function download(Request $request, string $token)
    {
        // Middleware đã xác thực và lưu order item vào request
        $orderItem = $request->attributes->get('orderItem');
        
        // Ghi log và cập nhật thông tin tải xuống
        $orderItem->download_count = ($orderItem->download_count ?? 0) + 1;
        $orderItem->downloaded_at = now();
        $orderItem->save();
        
        // Trả về file cho người dùng tải xuống
        $path = $orderItem->download_link;
        $filename = $orderItem->getDownloadableFileName();
        
        return Storage::disk('private')->download($path, $filename);
    }
    
    /**
     * Xử lý yêu cầu link tải mới
     */
    public function requestNewLink(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
        ]);
        
        $order = Order::with(['items.product', 'user'])->findOrFail($request->order_id);
        
        // Kiểm tra xem đơn hàng đã được thanh toán chưa
        if (!in_array($order->status, ['paid', 'completed'])) {
            return back()->with('error', 'Đơn hàng chưa được thanh toán, không thể tạo link tải xuống.');
        }
        
        // Tạo link tải xuống mới cho tất cả các item trong đơn hàng
        $downloadLinks = [];
        foreach ($order->items as $item) {
            if ($item->download_link && Storage::disk('private')->exists($item->download_link)) {
                $item->generateDownloadToken();
                
                $downloadLinks[] = [
                    'product' => $item->product->name,
                    'url' => $item->getDownloadUrl(),
                    'expires_at' => $item->token_expires_at,
                ];
            }
        }
        
        if (empty($downloadLinks)) {
            return back()->with('error', 'Không tìm thấy file tải xuống cho đơn hàng này.');
        }
        
        // Gửi email chứa các link tải mới
        Mail::to($order->user->email)->send(new DownloadLinkMail(
            $order,
            $downloadLinks,
            true // Đánh dấu là gửi lại link
        ));
        
        // Chuyển hướng đến trang xác nhận đã gửi
        return view('download.resent', [
            'order' => $order,
            'email' => $order->user->email,
        ]);
    }
}