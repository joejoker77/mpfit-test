@extends('layouts.index')
@section('content')
    <h1 class="mb-5 pt-4">Список товаров</h1>
    @if($products->isNotEmpty())
        <div class="products-list mb-5">
            @foreach($products as $product)
                <div class="card product-item">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{!! \Illuminate\Support\Str::limit($product->description, 150, '...', true) !!}</p>
                        <a href="{{ route('products.show', $product) }}" class="stretched-link"></a>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Цена: {{ \Illuminate\Support\Number::currency($product->getCost(), 'RUB', 'ru') }}</li>
                    </ul>
                    <div class="card-body">
                        <div class="product-controls d-flex flex-row justify-content-between">
                            <product-quantity style="max-width: 150px;z-index: 2">
                                <label for="elementQuantity-{{ $product->id }}">Количество</label>
                                <div class="input-group">
                                    <button class="minus input-group-text">
                                        <i class="material-symbols-outlined">remove</i>
                                    </button>
                                    <input class="form-control" type="number"
                                           id="elementQuantity-{{ $product->id }}"
                                           name="quantity" value="1"
                                    >
                                    <button class="plus input-group-text">
                                        <i class="material-symbols-outlined">add</i>
                                    </button>
                                </div>
                            </product-quantity>
                            <a href="#" class="btn btn-success order-btn d-block mt-auto"
                               data-product-id="{{ $product->id }}"
                               data-product-quantity="1"
                            >Заказать</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $products->appends(request()->input())->links() }}
    @endif
@endsection
