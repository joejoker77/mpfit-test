@php
use \Illuminate\Support\Carbon;
Carbon::setLocale('ru');
@endphp
@extends('layouts.index')
@section('content')
    <div class="mt-5 d-flex">
        <a href="{{ route('home') }}"><<< К списку товаров</a>
    </div>
    <div class="card mt-5">
        <div class="card-body">
            <h5 class="card-title">Ваш заказ № {{ $order->id }} успешно создан</h5>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Статус заказа: {{ $order->getStatus($order->current_status) }}</li>
            <li class="list-group-item">Дата создания заказа: {{ Carbon::parse($order->created_at)->format('d m Y') }}</li>
            @if($order->current_status === \App\Models\Shop\Order::COMPLETED)
                <li class="list-group-item">Дата создания заказа: {{ Carbon::parse($order->updated_at)->format('d m Y') }}</li>
            @endif
            <li class="list-group-item">Товар: {{ $order->orderItem->product->name }}</li>
            <li class="list-group-item">Количество: {{ $order->orderItem->quantity }} шт.</li>
            <li class="list-group-item">
                @if($order->orderItem->quantity === 1)Цена заказа: @else Цена товара:@endif
                    {{ \Illuminate\Support\Number::currency($order->orderItem->product->getCost(), 'RUB', 'ru') }}
            </li>
            @if($order->orderItem->quantity > 1)
                <li class="list-group-item">
                    Цена заказа: {{ \Illuminate\Support\Number::currency($order->orderItem->product->getCost() * $order->orderItem->quantity, 'RUB', 'ru') }}
                </li>
            @endif
        </ul>
        <div class="card-body">
            <h5>Комментарий к заказу</h5>
            <p>{{ $order->note }}</p>
        </div>
    </div>
@endsection
