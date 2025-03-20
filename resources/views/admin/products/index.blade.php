@extends('layouts.admin')

@section('content')
    <div class="py-4 d-flex">
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">Добавить продукт</a>
        <div class="ms-auto"></div>
    </div>
    <table class="table table-bordered table-striped" id="productTable">
        <thead>
        <tr>
            <th style="text-align: center">
                <input type="checkbox" class="form-check-input" name="select-all" style="cursor: pointer">
            </th>
            <th>
                <a class="link-secondary" href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'id' ? '-id' : 'id']) }}">
                    ID @if(request('sort') && request('sort') == 'id') <i data-feather="chevrons-up"></i> @endif
                    @if(request('sort') && request('sort') == '-id') <i data-feather="chevrons-down"></i> @endif
                </a>
            </th>
            <th>
                <a class="link-secondary" href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'name' ? '-name' : 'name']) }}">
                    Наименование @if(request('sort') && request('sort') == 'name') <i data-feather="chevrons-up"></i> @endif
                    @if(request('sort') && request('sort') == '-name') <i data-feather="chevrons-down"></i> @endif
                </a>
            </th>
            <th>Категория</th>
            <th>
                <a class="link-secondary" href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'price' ? '-price' : 'price']) }}">
                    Цена @if(request('sort') && request('sort') == 'price') <i data-feather="chevrons-up"></i> @endif
                    @if(request('sort') && request('sort') == '-price') <i data-feather="chevrons-down"></i> @endif
                </a>
            </th>
            <th>Действия</th>
        </tr>
        <tr>
            <form action="?" name="search-products" method="GET" id="searchProducts"></form>
            <td>&nbsp;</td>
            <td style="max-width: 50px;text-align: center">
                <input form="searchProducts" type="text" name="id" class="form-control" aria-label="Искать по ID" value="{{ request('id') }}">
            </td>
            <td style="max-width: 175px">
                <input type="text" form="searchProducts" name="name" class="form-control" aria-label="Искать по имени" value="{{ request('name') }}">
            </td>
            <td style="width: 250px">
                <select name="category" id="selectCategory" class="js-choices" form="searchProducts">
                    <option value="">-= Выбрать категорию =-</option>
                    @if($categories)
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected($category->id == request('category'))>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </td>
            <td style="max-width: 75px">
                <input type="text" name="price" class="form-control" form="searchProducts" value="{{ request('price') }}">
            </td>
            <td>&nbsp;</td>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td style="text-align: center">
                    <input form="formActions" type="checkbox" value="{{ $product->id }}" class="form-check-input" name="selected[]" style="cursor: pointer">
                </td>
                <td style="text-align: center">{{ $product->id }}</td>
                <td><a href="{{ route('admin.products.show', $product->slug) }}">{{ $product->name }}</a></td>
                <td>{{ $product->category->name }}</td>
                <td style="white-space: nowrap">{{ \Illuminate\Support\Number::currency($product->getCost(), 'RUB', 'ru') }}</td>
                <td style="white-space: nowrap">
                    <a href="{{ route('admin.products.show', $product) }}" class="list-inline-item mx-1"
                       id="viewProduct" data-bs-toggle="tooltip"
                       data-bs-placement="bottom"
                       data-bs-title="Просмотреть"
                    >
                        <span data-feather="eye"></span>
                    </a> |
                    <a href="{{ route('admin.products.edit', $product) }}" class="list-inline-item mx-1"
                       id="editProduct" data-bs-toggle="tooltip"
                       data-bs-placement="bottom"
                       data-bs-title="Редактировать"
                    >
                        <span data-feather="edit"></span>
                    </a> |
                    <form method="POST" class="list-inline-item js-confirm ms-2"
                          action="{{ route('admin.products.destroy', $product) }}"
                          data-bs-toggle="tooltip" data-bs-placement="bottom"
                          data-bs-title="Удалить продукт"
                    >
                        @csrf
                        @method('DELETE')
                        <button class="btn p-0 align-baseline js-confirm text-danger" type="submit"><span data-feather="trash-2"></span></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $products->appends(request()->input())->links() }}
@endsection
