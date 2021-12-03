@component('mail::message')


@component('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
@foreach ($order->details as $item)
| {{ $item->product->name }}      |  {{ $item->product->price }}   |   {{ $item->product->price * $item->qty}}    |
@endforeach
@endcomponent
{{-- 
@component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
