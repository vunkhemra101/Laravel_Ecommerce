<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::active()->latest()->get();
        $categories = Category::orderBy('name')->get();

        $searchQuery = trim($request->input('q') ?? $request->input('search') ?? '');

        $products = Product::with('category')
            ->active()
            ->when($request->filled('category'), function ($query) use ($request) {
                return $query->where('category_id', $request->input('category'));
            })
            ->when(!empty($searchQuery), function ($query) use ($searchQuery) {
                return $query->where('name', 'like', "%{$searchQuery}%");
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('home', compact('banners', 'categories', 'products'));
    }
}
