<?php

namespace App\UseCase;

use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use Illuminate\Support\Facades\DB;

class CreateOrderService
{
    public function checkout(array $request)
    {
        DB::beginTransaction();
        try {
            $order = Order::create([
                'current_status' => Order::NEW,
                'customer_name' => $request['customerName'],
                'note' => $request['customerNote'],
            ]);
            $order->saveOrFail();
            $items = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $request['productId'],
                'quantity' => $request['productQuantity'],
            ]);
            $items->saveOrFail();
            DB::commit();
            return $order;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception('Оформление заказа завершилось ошибкой:' . $exception->getMessage());
        }
    }
}
