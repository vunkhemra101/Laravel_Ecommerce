<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->take(5)
            ->get();

        $orderStatusCounts = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')->toArray();

        $salesByCategory = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('categories.name')
            ->pluck('total_quantity', 'categories.name')->toArray();

        $recentCustomers = User::where('role', 'customer')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.analytics', compact('topProducts', 'orderStatusCounts', 'salesByCategory', 'recentCustomers'));
    }
}
