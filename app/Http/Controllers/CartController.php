<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $sessionId = $this->getCartSessionId();
        $cartItems = CartItem::where('session_id', $sessionId)
            ->with('product')
            ->get();
            
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
            
        return view('pages.cart.index', compact('cartItems', 'subtotal'));
    }
    
    /**
     * Add a product to the shopping cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        $sessionId = $this->getCartSessionId();
        
        // Check if this product already exists in the cart
        $cartItem = CartItem::where('session_id', $sessionId)
            ->where('product_id', $product->id)
            ->first();
            
        if ($cartItem) {
            // Update quantity if product already in cart
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Add new item to cart
            CartItem::create([
                'session_id' => $sessionId,
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price,
                'quantity' => $quantity,
                'options' => [],
            ]);
        }
        
        // Check if this is a "Buy Now" request
        if ($request->has('buy_now')) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $product->name . ' added to your cart',
                    'cart_count' => $this->getCartItemsCount(),
                    'redirect' => route('checkout.index')
                ]);
            }
            
            return redirect()->route('checkout.index');
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $product->name . ' added to your cart',
                'cart_count' => $this->getCartItemsCount(),
            ]);
        }
        
        return redirect()->back()->with('success', $product->name . ' added to your cart');
    }
    
    /**
     * Update a cart item.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        $sessionId = $this->getCartSessionId();
        $cartItem = CartItem::where('session_id', $sessionId)
            ->where('id', $id)
            ->firstOrFail();
            
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        if ($request->ajax()) {
            $cartItems = CartItem::where('session_id', $sessionId)->get();
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });
            
            return response()->json([
                'success' => true,
                'item_total' => number_format($cartItem->price * $cartItem->quantity, 2),
                'cart_subtotal' => number_format($subtotal, 2),
                'cart_count' => $this->getCartItemsCount(),
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully');
    }
    
    /**
     * Remove a cart item.
     */
    public function remove($id)
    {
        $sessionId = $this->getCartSessionId();
        $cartItem = CartItem::where('session_id', $sessionId)
            ->where('id', $id)
            ->firstOrFail();
        
        $cartItem->delete();
        
        if (request()->ajax()) {
            $cartItems = CartItem::where('session_id', $sessionId)->get();
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });
            
            return response()->json([
                'success' => true,
                'cart_subtotal' => number_format($subtotal, 2),
                'cart_count' => $this->getCartItemsCount(),
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Item removed from cart');
    }
    
    /**
     * Clear the shopping cart.
     */
    public function clear()
    {
        $sessionId = $this->getCartSessionId();
        CartItem::where('session_id', $sessionId)->delete();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => 0,
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully');
    }
    
    /**
     * Get cart mini-summary (for AJAX requests)
     */
    public function miniCart()
    {
        $sessionId = $this->getCartSessionId();
        $cartItems = CartItem::where('session_id', $sessionId)
            ->with('product')
            ->get();
            
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        return response()->json([
            'success' => true,
            'cart_count' => $cartItems->sum('quantity'),
            'cart_subtotal' => number_format($subtotal, 2),
            'cart_items' => $cartItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => number_format($item->price, 2),
                    'quantity' => $item->quantity,
                    'total' => number_format($item->price * $item->quantity, 2),
                    'image' => $item->product->thumbnail ? asset('storage/' . $item->product->thumbnail) : null,
                ];
            }),
        ]);
    }
    
    /**
     * Get the cart session ID (create if not exists).
     */
    private function getCartSessionId()
    {
        if (!Session::has('cart_id')) {
            Session::put('cart_id', Str::uuid()->toString());
        }
        
        return Session::get('cart_id');
    }
    
    /**
     * Get the total count of items in the cart.
     */
    private function getCartItemsCount()
    {
        $sessionId = $this->getCartSessionId();
        return CartItem::where('session_id', $sessionId)->sum('quantity');
    }
}
