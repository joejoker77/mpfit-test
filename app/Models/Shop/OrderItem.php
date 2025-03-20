<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    protected $table = 'shop_order_items';

    public $timestamps = false;

    protected $fillable = [
        'order_id', 'product_id', 'quantity',
    ];

    public function product():HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function order():belongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
