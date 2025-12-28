<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Cart;

class CartItemController extends Controller
{
    protected function getOrCreateCart()
    {
        $currentCart = app('currentCart');

        if (!$currentCart) {
            $currentCart = Cart::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
            ]);
        }

        return $currentCart;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();

        // check if already exist in cart then call update
        $cartItem = $cart->cartItems()->where('product_id', $validated['product_id'])->first();
        if ($cartItem) {
            $request->merge([
                'quantity' => $cartItem->quantity + $validated['quantity']
            ]);
            return $this->update($request, $cartItem);
        }

        $product = Product::find($validated['product_id']);
        $validated['name'] = $product->name;
        $validated['unit_price'] = $product->price;
        $validated['line_total'] = $product->price * $validated['quantity'];
        $validated['cart_id'] = $cart->id;
        
        $cartItem = CartItem::create($validated);

        return back()->with('success', 'Product added to cart');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = $cartItem->product;
        $validated['line_total'] = $cartItem->unit_price * $validated['quantity'];

        $cartItem->update($validated);

        return back()->with('success', 'Cart item updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return back()->with('success', 'Cart item removed');
    }
}
