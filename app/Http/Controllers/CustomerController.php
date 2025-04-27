<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display the customer dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Get recent orders
        $recentOrders = $user->orders()
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        // Get downloadable items
        $downloads = OrderItem::whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereHas('product', function ($query) {
                $query->where('is_downloadable', true);
            })
            ->with('product')
            ->take(3)
            ->get();
        
        return view('customer.dashboard', compact('recentOrders', 'downloads'));
    }
    
    /**
     * Display the customer profile page.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('customer.profile');
    }
    
    /**
     * Display the customer orders.
     *
     * @return \Illuminate\View\View
     */
    public function orders()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Get all orders with items and products
        $orders = $user->orders()
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('customer.orders', compact('orders'));
    }
    
    /**
     * Display the customer downloads.
     *
     * @return \Illuminate\View\View
     */
    public function downloads()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Get all orders with downloadable items
        $orders = $user->orders()
            ->with(['items' => function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('is_downloadable', true);
                })->with('product');
            }])
            ->has('items.product')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('customer.downloads', compact('orders'));
    }
    
    /**
     * Download a digital product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $item
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request, $item)
    {
        // Find the order item
        $orderItem = OrderItem::findOrFail($item);
        
        // Check if the user owns this order item
        $userOwnsItem = $orderItem->order->user_id === Auth::id();
        
        // Check if the download token is valid
        $validToken = $request->token === $orderItem->download_token;
        
        // Check if download is still allowed (limits and expiry)
        $downloadAllowed = (!$orderItem->download_limit || $orderItem->download_count < $orderItem->download_limit) &&
                         (!$orderItem->download_expiry || now()->lessThan($orderItem->download_expiry));
        
        if (!$userOwnsItem || !$validToken || !$downloadAllowed) {
            abort(403, 'Unauthorized download attempt');
        }
        
        // Increment download count
        $orderItem->increment('download_count');
        
        // Get the download path (this would be based on your storage setup)
        $downloadPath = $orderItem->product->download_path;
        
        // Check if the file exists
        if (!Storage::exists($downloadPath)) {
            return back()->with('error', 'Download file not found. Please contact support.');
        }
        
        // Return the file download
        return Storage::download($downloadPath, $orderItem->product->name . '.zip');
    }
    
    /**
     * Generate a new download token for an order item.
     *
     * @param  int  $item
     * @return string
     */
    protected function generateDownloadToken($item)
    {
        $token = Str::random(64);
        
        // Update the order item with the new token
        OrderItem::where('id', $item)->update([
            'download_token' => $token,
        ]);
        
        return $token;
    }
}