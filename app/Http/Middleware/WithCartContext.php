<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;

class WithCartContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cart = $this->getCurrentCart();

        app()->singleton('currentCart', fn () => $cart?->load('cartItems'));

        Inertia::share('currentCart', $cart?->load('cartItems'));

        return $next($request);
    }

    protected function getCurrentCart()
    {
        if (!auth()->check()) {
            return null;
        }

        return auth()->user()->pendingCart;
    }
}
