<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $productsCount = Product::count();
        $usersCount = User::where('role', 'customer')->count();
        $ordersCount = Order::count();
        $revenueSum = Order::where('status', '!=', 'cancelled')->sum('total_amount');

        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->take(5)->get();

        $dailyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dailyRevenue[$date] = Order::whereDate('created_at', $date)->where('status', '!=', 'cancelled')->sum('total_amount');
        }

        $orderStatuses = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.dashboard', compact('productsCount', 'usersCount', 'ordersCount', 'revenueSum', 'recentOrders', 'dailyRevenue', 'orderStatuses'));
    }
}
