@extends('layouts.admin')

@section('content')
    <div class="py-4 d-flex">
        <h1>Заказы</h1>
        <div class="ms-auto"></div>
    </div>
    <table class="table table-bordered table-striped" id="orderTable">
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
                <a class="link-secondary" href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'created_at' ? '-created_at' : 'created_at']) }}">
                    Дата создания @if(request('sort') && request('sort') == 'created_at') <i data-feather="chevrons-up"></i> @endif
                    @if(request('sort') && request('sort') == '-created_at') <i data-feather="chevrons-down"></i> @endif
                </a>
            </th>
            <th>
                <a class="link-secondary" href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'customer_name' ? '-customer_name' : 'customer_name']) }}">
                    Ф.И.О. покупателя @if(request('sort') && request('sort') == 'customer_name') <i data-feather="chevrons-up"></i> @endif
                    @if(request('sort') && request('sort') == '-customer_name') <i data-feather="chevrons-down"></i> @endif
                </a>
            </th>
            <th>
                <a class="link-secondary" href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'current_status' ? '-current_status' : 'current_status']) }}">
                    Текущий статус @if(request('sort') && request('sort') == 'current_status') <i data-feather="chevrons-up"></i> @endif
                    @if(request('sort') && request('sort') == '-current_status') <i data-feather="chevrons-down"></i> @endif
                </a>
            </th>
            <th>Итоговая цена</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td style="text-align: center">
                    <input form="formActions" type="checkbox" value="{{ $order->id }}" class="form-check-input" name="selected[]" style="cursor: pointer">
                </td>
                <td style="text-align: center">{{ $order->id }}</td>
                <td>{{ $order->created_at }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->getStatus($order->current_status) }}</td>
                <td style="white-space: nowrap">{{ \Illuminate\Support\Number::currency($order->getTotalCost(), 'RUB', 'ru') }}</td>
                <td style="white-space: nowrap">
                    <a href="{{ route('admin.orders.show', $order) }}" class="list-inline-item mx-1"
                       id="viewOrder" data-bs-toggle="tooltip"
                       data-bs-placement="bottom"
                       data-bs-title="Просмотреть"
                    >
                        <span data-feather="eye"></span>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $orders->appends(request()->input())->links() }}
@endsection
