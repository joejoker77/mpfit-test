<?php

namespace App\Models\Shop;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id

 * @property string $name
 * @property string $slug
 *
 * @property Collection $products
 */

class Category extends Model
{
    public $timestamps = false;

    protected $table = 'shop_categories';

    protected $fillable = ['name', 'slug'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function getPath():string
    {
        return implode('/', array_merge($this->ancestors()->pluck('slug')->toArray(), [$this->slug]));
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}

