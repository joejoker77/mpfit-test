<?php

namespace App\Models\Shop;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property float $cost
 * @property string $description
 * @property int $category_id
 *
 * @property Category $category
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'shop_products';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'cost',
    ];

    public static function boot()
    {
        parent::boot();

        // Model::preventLazyLoading();
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
            $model->cost = $model->cost * 100;
        });
        static::updating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function getCost(): float
    {
        return $this->cost / 100;
    }
}
