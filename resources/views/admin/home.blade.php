@extends('layouts.admin')
@section('content')
    <h1 class="py-4">Hello Admin</h1>
    <ul style="list-style: none;margin: 0;padding: 0">
        <li style="margin-bottom: 15px">
            <a href="{{ route('admin.products.index') }}" class="btn btn-info">Перейти к товарам</a>
        </li>
        <li>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-info">Перейти к заказам</a>
        </li>
    </ul>
@endsection
