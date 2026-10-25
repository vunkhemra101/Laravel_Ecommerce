<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        if ($product->stock_qty < $request->quantity) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Not enough stock'], 400);
            }
            return back()->with('error', 'Not enough stock available');
        }

        $cart = Session::get('cart', []);
        
        $size = $request->size ?? 'default';
        $cartKey = $product->id . '_' . $size;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'size' => $size,
                'image' => $product->image,
            ];
        }

        Session::put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            $totalQty = 0;
            foreach ($cart as $item) {
                $totalQty += $item['quantity'];
            }
            return response()->json([
                'success' => 'Item added to cart',
                'cart_count' => $totalQty
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->cart_key])) {
            $product = Product::find($cart[$request->cart_key]['product_id']);
            
            if ($product && $product->stock_qty >= $request->quantity) {
                $cart[$request->cart_key]['quantity'] = $request->quantity;
                Session::put('cart', $cart);
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => 'Cart updated successfully']);
                }
                return back()->with('success', 'Cart updated successfully');
            }
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Not enough stock'], 400);
            }
            return back()->with('error', 'Not enough stock available');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['error' => 'Item not found in cart'], 404);
        }
        return back()->with('error', 'Item not found in cart');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string'
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->cart_key])) {
            unset($cart[$request->cart_key]);
            Session::put('cart', $cart);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => 'Item removed from cart']);
            }
            return back()->with('success', 'Item removed from cart');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['error' => 'Item not found in cart'], 404);
        }
        return back()->with('error', 'Item not found in cart');
    }
}
