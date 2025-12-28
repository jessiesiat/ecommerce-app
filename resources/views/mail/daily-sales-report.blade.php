<x-mail::message>
# Daily Sales Report

Date: {{ now()->toDateString() }}

<x-mail::table>
| Product Name      | Quantity Sold   |
| :------------     | :-----------: | 
@foreach ($groupedCartItems as $item)
| {{ $item['product_name'] }} | {{ $item['total_quantity'] }} |
@endforeach
</x-mail::table>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
