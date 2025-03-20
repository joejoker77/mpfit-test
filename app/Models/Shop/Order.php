<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    const NEW = 1;
    const COMPLETED = 2;

    protected $table = 'shop_orders';

    protected $fillable = [
        'note',
        'current_status',
        'customer_name',
    ];

    public static function statusesList():array
    {
        return [
            self::NEW       => 'Новый',
            self::COMPLETED => 'Завершен',
        ];
    }

    public function getStatus($status):string
    {
        return self::statusesList()[$status];
    }

    public function isCompleted():bool
    {
        return $this->current_status == self::COMPLETED;
    }

    public function complete(): void
    {
        if ($this->isCompleted()) {
            throw new \DomainException('Заказ уже завершен.');
        }
        $this->current_status = self::COMPLETED;
    }

    public function getTotalCost():float
    {
        return $this->orderItem->product->getCost() * $this->orderItem->quantity;
    }

    public function orderItem():HasOne
    {
        return $this->hasOne(OrderItem::class);
    }
}
