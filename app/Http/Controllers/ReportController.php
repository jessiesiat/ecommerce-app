<?php

namespace App\Http\Controllers;

use App\Mail\DailySalesReport;
use App\Models\CartItem;

class ReportController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $cartItemsToday = CartItem::whereHas('cart', function ($query) use ($today) {
            $query->whereDate('payment_date', $today);
        })
            ->with('product')
            ->get();

        // Group cart items by product id
        $groupedCartItems = $cartItemsToday
            ->groupBy('product_id')
            ->map(function ($items) {
                $productName = optional($items->first()->product)->name;
                $quantitySum = $items->sum('quantity');

                return [
                    'product_name' => $productName,
                    'total_quantity' => $quantitySum,
                ];
            });
        // dd($groupedCartItems);

        return (new DailySalesReport($groupedCartItems))->render();
    }
}
