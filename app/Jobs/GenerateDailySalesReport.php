<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailySalesReport;
use App\Models\CartItem;

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
        $groupedCartItems = $cartItemsToday->groupBy('product_id');

        Mail::to('admin@example.com')->queue(new DailySalesReport($groupedCartItems));
    }
}
