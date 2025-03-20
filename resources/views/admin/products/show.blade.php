@extends('layouts.admin')
@section('content')
    <div class="pt-4 d-flex">
        <div class="ms-auto btn-group" role="group" aria-label="control buttons">
            <a href="{{ route('admin.products.create') }}" class="btn btn-success d-flex" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Создать">
                <span data-feather="plus-square"></span>
            </a>
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary d-flex" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Редактировать">
                <span data-feather="edit"></span>
            </a>
            <form class="btn btn-danger" method="POST" action="{{ route('admin.products.destroy', $product) }}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Удалить">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn p-0 text-white d-flex js-confirm" style="line-height: 0">
                    <span data-feather="trash-2"></span>
                </button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <h6>Продукт</h6>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>ID</th>
                    <td>{{ $product->id }}</td>
                </tr>
                <tr>
                    <th>Наименование</th>
                    <td>{{ $product->name }}</td>
                </tr>
                <tr>
                    <th>Цена</th>
                    <td>{{ \Illuminate\Support\Number::currency($product->getCost(), 'RUB', 'ru') }}</td>
                </tr>
                @if($product->category)
                    <tr>
                        <th>Категория</th>
                        <td>{{ $product->category->name }}</td>
                    </tr>
                @endif
            </table>
            <div class="pt-5">
                <h6>Описание продукта</h6>
                <p>{!! $product->description !!}</p>
            </div>
        </div>
    </div>
@endsection
