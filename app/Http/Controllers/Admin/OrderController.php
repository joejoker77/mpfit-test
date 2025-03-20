<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Traits\QueryParams;
use App\Models\Shop\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    use QueryParams;

    public function index(Request $request): View
    {
        $query = Order::with(['orderItem']);
        $this->queryParams($request, $query);
        $orders = $query->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', compact('order'));
    }

    public function setStatus(Order $order): RedirectResponse
    {
        $order->complete();
        $order->save();
        return back()->with('success', 'Статус заказа успешно изменен на завершенный');
    }
}
