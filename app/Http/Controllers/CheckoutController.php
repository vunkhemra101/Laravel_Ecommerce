<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
                
                // Verify stock again
                $product = Product::lockForUpdate()->find($item['product_id']);
                if (!$product || $product->stock_qty < $item['quantity']) {
                    throw new \Exception("Product {$item['name']} is out of stock or does not have enough quantity.");
                }
            }

            $orderNumber = 'ORD-' . strtoupper(uniqid());

            $order = Order::create([
                'order_number'     => $orderNumber,
                'user_id'          => auth()->id(),
                'total_amount'     => $total,
                'status'           => 'pending',
                'shipping_address' => $request->address,
                'phone'            => $request->phone,
                'payment_method'   => $request->payment_method ?? 'Cash on Delivery',
                'order_date'       => now(),
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                
                // Decrement stock
                $product = Product::find($item['product_id']);
                $product->decrement('stock_qty', $item['quantity']);
            }

            DB::commit();

            Session::forget('cart');

            return redirect()->route('profile.index')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }
}
