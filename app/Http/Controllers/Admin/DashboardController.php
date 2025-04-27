<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index(): View
    {
        // Số liệu thống kê cơ bản
        $stats = [
            'orders' => Order::count(),
            'products' => Product::count(),
            'customers' => User::where('role', 'customer')->count(),
            'revenue' => Order::where('status', 'paid')->sum('total_price'),
            'posts' => Post::count(),
            'pending_orders' => Order::where('status', 'pending')->count()
        ];

        // Đơn hàng gần đây với thông tin khách hàng
        $recentOrders = Order::with('user', 'orderItems.product')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Thống kê doanh thu theo thời gian
        $revenueData = $this->getRevenueData();

        // Sản phẩm bán chạy
        $topProducts = DB::table('products')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'paid')
            ->select('products.id', 'products.name', DB::raw('COUNT(order_items.id) as sales_count'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();

        // Khách hàng mới
        $newCustomers = User::where('role', 'customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'recentOrders', 
            'revenueData', 
            'topProducts', 
            'newCustomers'
        ));
    }

    /**
     * Lấy dữ liệu doanh thu cho biểu đồ
     */
    private function getRevenueData()
    {
        // Doanh thu 30 ngày gần nhất (theo tuần)
        $revenueByWeek = Order::where('status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('WEEK(created_at) as week'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('week')
            ->orderBy('week')
            ->get()
            ->keyBy('week');

        // Tạo mảng dữ liệu cho 4 tuần gần nhất
        $weeklyData = [];
        $weekLabels = [];

        for ($i = 0; $i < 4; $i++) {
            $week = Carbon::now()->subWeeks($i)->week;
            $weekStart = Carbon::now()->subWeeks($i)->startOfWeek()->format('d/m');
            $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek()->format('d/m');
            
            $weekLabels[$i] = "{$weekStart} - {$weekEnd}";
            $weeklyData[$i] = $revenueByWeek->get($week) ? $revenueByWeek->get($week)->total : 0;
        }

        $weeklyData = array_reverse($weeklyData);
        $weekLabels = array_reverse($weekLabels);

        // Doanh thu 7 ngày gần nhất
        $dailyData = [];
        $dailyLabels = [];

        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays($i);
            $dailyLabels[$i] = $date->format('d/m');
            
            $revenue = Order::where('status', 'paid')
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->sum('total_price');
                
            $dailyData[$i] = $revenue;
        }

        $dailyData = array_reverse($dailyData);
        $dailyLabels = array_reverse($dailyLabels);

        // Doanh thu theo tháng trong năm nay
        $monthlyData = [];
        $monthlyLabels = [];
        $currentYear = Carbon::now()->year;

        for ($i = 1; $i <= 12; $i++) {
            $monthlyLabels[] = "Tháng {$i}";
            
            $revenue = Order::where('status', 'paid')
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $i)
                ->sum('total_price');
                
            $monthlyData[] = $revenue;
        }

        return [
            'daily' => [
                'labels' => $dailyLabels,
                'data' => $dailyData
            ],
            'weekly' => [
                'labels' => $weekLabels,
                'data' => $weeklyData
            ],
            'monthly' => [
                'labels' => $monthlyLabels,
                'data' => $monthlyData
            ]
        ];
    }
}
