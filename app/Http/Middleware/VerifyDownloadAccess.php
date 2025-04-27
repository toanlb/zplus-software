<?php

namespace App\Http\Middleware;

use App\Models\OrderItem;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyDownloadAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->route('token');
        
        // Tìm order item dựa trên token
        $orderItem = OrderItem::where('download_token', $token)->first();
        
        if (!$orderItem) {
            return redirect()->route('download.expired');
        }
        
        // Kiểm tra xem token có hợp lệ không
        if (!$orderItem->isDownloadTokenValid()) {
            return view('download.expired', [
                'orderItem' => $orderItem,
                'token' => $token
            ]);
        }
        
        // Kiểm tra xem đơn hàng đã được thanh toán chưa
        if (!$orderItem->order || !in_array($orderItem->order->status, ['paid', 'completed'])) {
            return abort(403, 'Đơn hàng chưa được thanh toán.');
        }
        
        // Kiểm tra xem file có tồn tại không
        if (!$orderItem->download_link || !\Storage::disk('private')->exists($orderItem->download_link)) {
            return abort(404, 'File không tồn tại trong hệ thống.');
        }
        
        // Lưu order item vào request để controller có thể sử dụng
        $request->attributes->set('orderItem', $orderItem);
        
        return $next($request);
    }
}
