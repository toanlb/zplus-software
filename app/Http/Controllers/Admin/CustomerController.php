<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\License;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $customers = User::where('role', 'customer')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('company', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();
        
        // Thống kê tổng quan về khách hàng
        $stats = [
            'total' => User::where('role', 'customer')->count(),
            'new_this_month' => User::where('role', 'customer')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
        
        return view('admin.customers.index', compact('customers', 'stats', 'search'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'website' => 'nullable|string|url|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'customer'; // Đảm bảo role là customer
        
        $customer = User::create($validated);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Tạo khách hàng mới thành công.');
    }

    /**
     * Display the specified customer.
     */
    public function show(User $customer)
    {
        // Kiểm tra xem người dùng có phải khách hàng không
        if ($customer->role !== 'customer') {
            abort(404);
        }
        
        // Lấy thông tin đơn hàng của khách hàng
        $orders = Order::where('user_id', $customer->id)
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Thống kê chi tiêu của khách hàng
        $totalSpent = $orders->whereIn('status', ['paid', 'completed'])->sum('total_price');
        $avgOrderValue = $orders->whereIn('status', ['paid', 'completed'])->count() > 0
            ? $totalSpent / $orders->whereIn('status', ['paid', 'completed'])->count()
            : 0;
            
        // Lấy danh sách tải xuống gần đây
        $recentDownloads = OrderItem::whereHas('order', function ($query) use ($customer) {
                $query->where('user_id', $customer->id);
            })
            ->whereNotNull('downloaded_at')
            ->with('product')
            ->orderBy('downloaded_at', 'desc')
            ->limit(5)
            ->get();
        
        // Lấy danh sách license của khách hàng
        $licenses = License::whereHas('orderItem.order', function ($query) use ($customer) {
                $query->where('user_id', $customer->id);
            })
            ->with(['product', 'orderItem.order'])
            ->get();
            
        return view('admin.customers.show', compact(
            'customer',
            'orders',
            'totalSpent',
            'avgOrderValue',
            'recentDownloads',
            'licenses'
        ));
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(User $customer)
    {
        // Kiểm tra xem người dùng có phải khách hàng không
        if ($customer->role !== 'customer') {
            abort(404);
        }
        
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, User $customer)
    {
        // Kiểm tra xem người dùng có phải khách hàng không
        if ($customer->role !== 'customer') {
            abort(404);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($customer->id),
            ],
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'website' => 'nullable|string|url|max:255',
            'notes' => 'nullable|string',
            'password' => 'nullable|string|min:8',
        ]);

        // Chỉ cập nhật mật khẩu nếu được cung cấp
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        $customer->update($validated);
        
        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Cập nhật thông tin khách hàng thành công.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(User $customer)
    {
        // Kiểm tra xem người dùng có phải khách hàng không
        if ($customer->role !== 'customer') {
            abort(404);
        }
        
        // Xóa khách hàng
        $customer->delete();
        
        return redirect()->route('admin.customers.index')
            ->with('success', 'Đã xóa khách hàng thành công.');
    }
    
    /**
     * Display download history for the customer.
     */
    public function downloads(User $customer)
    {
        // Kiểm tra xem người dùng có phải khách hàng không
        if ($customer->role !== 'customer') {
            abort(404);
        }
        
        // Lấy lịch sử tải xuống của khách hàng
        $downloads = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select(
                'order_items.*',
                'products.name as product_name',
                'orders.order_number'
            )
            ->where('orders.user_id', $customer->id)
            ->whereNotNull('order_items.download_link')
            ->orderBy('order_items.downloaded_at', 'desc')
            ->paginate(15);
            
        // Thống kê tải xuống
        $stats = [
            'total_downloads' => DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('orders.user_id', $customer->id)
                ->sum('order_items.download_count'),
            'last_download' => DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('orders.user_id', $customer->id)
                ->whereNotNull('order_items.downloaded_at')
                ->latest('order_items.downloaded_at')
                ->value('order_items.downloaded_at')
        ];
            
        return view('admin.customers.downloads', compact('customer', 'downloads', 'stats'));
    }
    
    /**
     * Display licenses for the customer.
     */
    public function licenses(User $customer)
    {
        // Kiểm tra xem người dùng có phải khách hàng không
        if ($customer->role !== 'customer') {
            abort(404);
        }
        
        // Lấy danh sách license của khách hàng
        $licenses = License::whereHas('orderItem.order', function ($query) use ($customer) {
                $query->where('user_id', $customer->id);
            })
            ->with(['product', 'orderItem.order'])
            ->paginate(15);
            
        return view('admin.customers.licenses', compact('customer', 'licenses'));
    }
}
