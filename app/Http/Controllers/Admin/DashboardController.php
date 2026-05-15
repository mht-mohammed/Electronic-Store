<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue'   => Order::where('status', 'delivered')->sum('total'),
            'total_orders'    => Order::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_products'  => Product::count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'low_stock'       => Product::where('stock', '<', 5)->count(),
        ];

        // مبيعات آخر 12 شهر
        $salesChart = Order::where('status', 'delivered')
            ->selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $months = [
            1 => 'يناير',
            2 => 'فبراير',
            3 => 'مارس',
            4 => 'أبريل',
            5 => 'مايو',
            6 => 'يونيو',
            7 => 'يوليو',
            8 => 'أغسطس',
            9 => 'سبتمبر',
            10 => 'أكتوبر',
            11 => 'نوفمبر',
            12 => 'ديسمبر'
        ];

        $chartLabels = [];
        $chartData   = [];
        for ($m = 1; $m <= 12; $m++) {
            $chartLabels[] = $months[$m];
            $chartData[]   = $salesChart[$m] ?? 0;
        }

        // أحدث 6 طلبات
        $latestOrders = Order::with('user')->latest()->take(6)->get();

        // أكثر المنتجات مبيعاً
        $topProducts = Product::withCount([
            'orderItems as sold_count' => fn($q) => $q->selectRaw('SUM(quantity)')
        ])
            ->orderByDesc('sold_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'chartLabels',
            'chartData',
            'latestOrders',
            'topProducts'
        ));
    }
}
