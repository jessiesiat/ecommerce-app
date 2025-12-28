<?php

namespace App\Observers;

use App\Mail\LowStockNotification;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;

class ProductObserver
{
    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        if ($product->stock_quantity <= $product->low_stock_threshold) {
            Mail::to('admin@example.com')->queue(new LowStockNotification($product));
        }
    }
}
