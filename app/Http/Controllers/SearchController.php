<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim($request->input('q', ''));

        if (mb_strlen($query) < 1) {
            return response()->json([]);
        }

        $products = Product::with('category')
            ->active()
            ->where('name', 'like', "%{$query}%")
            ->take(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => number_format((float)$product->price, 2),
                    'category_name' => $product->category ? $product->category->name : '',
                    'image_url' => $product->image
                        ? asset('assets/uploads/products/' . $product->image)
                        : asset('assets/images/logo12.png'),
                    'url' => route('product.show', $product->id),
                ];
            });

        return response()->json($products);
    }
}
