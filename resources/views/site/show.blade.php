@extends('layouts.index')
@section('content')
    <div class="mt-5 d-flex">
        <a href="{{ route('home') }}"><<< К списку товаров</a>
    </div>
    <div class="card product-card mt-5">
        <div class="card-body">
            <h1 class="card-title">{{ $product->name }}</h1>
            <p class="card-text">{!! $product->description !!}</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Цена: {{ \Illuminate\Support\Number::currency($product->getCost(), 'RUB', 'ru') }}</li>
        </ul>
        <div class="card-body">
            <a href="#" class="btn btn-success" data-product-id="{{ $product->id }}">Заказать</a>
        </div>
    </div>
@endsection
