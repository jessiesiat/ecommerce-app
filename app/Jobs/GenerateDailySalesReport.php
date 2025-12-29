<?php

namespace App\Jobs;

use App\Mail\DailySalesReport;
use App\Models\CartItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class GenerateDailySalesReport implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
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

        Mail::to('admin@example.com')->queue(new DailySalesReport($groupedCartItems));
    }
}
