<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderItem;

class ReportController extends Controller
{
    public function index()
    {
        $lowStockProducts = Product::where('stock_qty', '<', 10)->get();

        $recentSales = OrderItem::with(['product', 'order', 'order.user'])
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return view('admin.reports', compact('lowStockProducts', 'recentSales'));
    }
}
