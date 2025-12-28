<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Inertia\Inertia;

class CartController extends Controller
{
    public function checkout()
    {
        $cart = app('currentCart');
        $cart->status = 'confirmed';
        $cart->payment_date = now();
        $cart->save();

        foreach ($cart->cartItems as $cartItem) {
            $product = $cartItem->product;
            $product->decrement('stock_quantity', $cartItem->quantity);
        }

        return redirect()->route('order.cart.summary', $cart->id)->with('success', 'Cart checked out successfully');
    }

    public function summary(Cart $cart)
    {
        return Inertia::render('order/cart/summary', [
            'cart' => $cart->load('cartItems'),
        ]);
    }
}
