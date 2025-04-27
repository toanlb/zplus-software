<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page
     */
    public function index()
    {
        // Get cart items
        $sessionId = $this->getCartSessionId();
        $cartItems = CartItem::where('session_id', $sessionId)
            ->with('product')
            ->get();
            
        // If cart is empty, redirect to cart page
        if ($cartItems->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        // Calculate order totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        // For now, tax and shipping are set to 0
        $tax = 0;
        $shipping = 0;
        $total = $subtotal + $tax + $shipping;
        
        return view('pages.checkout.index', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }
    
    /**
     * Process the checkout
     */
    public function process(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'payment_method' => 'required|in:credit_card,paypal',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Get cart items
        $sessionId = $this->getCartSessionId();
        $cartItems = CartItem::where('session_id', $sessionId)
            ->with('product')
            ->get();
            
        // If cart is empty, redirect to cart page
        if ($cartItems->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        try {
            // Start transaction
            DB::beginTransaction();
            
            // Calculate order totals
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });
            
            // For now, tax and shipping are set to 0
            $tax = 0;
            $shipping = 0;
            $total = $subtotal + $tax + $shipping;
            
            // Create order
            $order = new Order();
            $order->user_id = Auth::check() ? Auth::id() : null;
            $order->order_number = Order::generateOrderNumber();
            $order->status = 'pending'; // Initial status
            $order->payment_method = $request->payment_method;
            $order->total_price = $total;
            $order->name = $request->name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->notes = $request->notes;
            $order->save();
            
            // Create order items
            foreach ($cartItems as $cartItem) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cartItem->product_id;
                $orderItem->price = $cartItem->price;
                $orderItem->quantity = $cartItem->quantity;
                $orderItem->save();
                
                // Generate download token for digital products
                if ($cartItem->product && $cartItem->product->download_link) {
                    $orderItem->generateDownloadToken();
                }
            }
            
            // Clear cart
            CartItem::where('session_id', $sessionId)->delete();
            
            // Commit transaction
            DB::commit();
            
            // For now, we'll assume payment will be handled separately
            // In a real application, you would integrate with a payment gateway here
            
            return redirect()->route('checkout.complete', ['order' => $order->id]);
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error processing your order: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Display the order complete page
     */
    public function complete(Order $order)
    {
        // Security check - only allow viewing if the order belongs to logged in user or session
        if (Auth::check()) {
            if (Auth::id() !== $order->user_id) {
                abort(403, 'Unauthorized');
            }
        } elseif (Session::get('recent_order_id') !== $order->id) {
            abort(403, 'Unauthorized');
        }
        
        $order->load('items.product');
        
        return view('pages.checkout.complete', compact('order'));
    }
    
    /**
     * Handle payment confirmation (this would integrate with an actual payment gateway)
     */
    public function confirmPayment(Order $order)
    {
        // In a real application, this would handle callback from payment gateway
        // For now, we'll just update the order status
        
        $order->status = 'paid';
        $order->paid_at = now();
        $order->save();
        
        // Store recent order ID in session for non-logged in users
        Session::put('recent_order_id', $order->id);
        
        return redirect()->route('checkout.complete', ['order' => $order->id])
            ->with('success', 'Payment confirmed successfully');
    }
    
    /**
     * Get the cart session ID
     */
    private function getCartSessionId()
    {
        if (!Session::has('cart_id')) {
            Session::put('cart_id', \Illuminate\Support\Str::uuid()->toString());
        }
        
        return Session::get('cart_id');
    }
}
