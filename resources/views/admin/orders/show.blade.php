@php
    use \Illuminate\Support\Carbon;
    Carbon::setLocale('ru');
@endphp
@extends('layouts.admin')
@section('content')
    <div class="mt-5 d-flex">
        <a href="{{ route('admin.orders.index') }}"><<< К списку заказов</a>
    </div>
    <div class="card mt-5">
        <div class="card-body">
            <h5 class="card-title">Заказ № {{ $order->id }}</h5>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex flex-row justify-content-between">
                Статус заказа: {{ $order->getStatus($order->current_status) }}
                @if($order->current_status === \App\Models\Shop\Order::NEW)
                    <form action="{{ route('admin.order.set-status', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Завершить заказ</button>
                    </form>
                @endif
            </li>
            <li class="list-group-item">Дата создания заказа: {{ Carbon::parse($order->created_at)->format('d m Y') }}</li>
            @if($order->current_status === \App\Models\Shop\Order::COMPLETED)
                <li class="list-group-item">Дата создания заказа: {{ Carbon::parse($order->updated_at)->format('d m Y') }}</li>
            @endif
            <li class="list-group-item">Товар: <a href="{{ route('admin.products.show', $order->orderItem->product) }}">{{ $order->orderItem->product->name }}</a></li>
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






