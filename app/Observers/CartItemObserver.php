<?php

namespace App\Observers;

use App\Models\CartItem;

class CartItemObserver
{
    /**
     * Handle the CartItem "saved" event.
     */
    public function saved(CartItem $cartItem): void
    {
        $cart = $cartItem->cart;
        $cart->total_amount = $cart->cartItems->sum('line_total');
        $cart->save();
    }
}
