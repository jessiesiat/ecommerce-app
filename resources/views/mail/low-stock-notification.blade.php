<x-mail::message>
# Low Stock Notification

The product {{ $product->name }} is running low on stock.

Current stock: {{ $product->stock_quantity }}

Low stock threshold: {{ $product->low_stock_threshold }}

Please restock the product.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
