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
        $banners = Banner::where('is_active', 'active')->get();
        $categories = Category::all();
        
        $category_id = $request->input('category_id');
        
        $products = Product::when($category_id, function ($query, $category_id) {
            return $query->where('category_id', $category_id);
        })->paginate(12);

        return view('home', compact('banners', 'categories', 'products'));
    }
}
