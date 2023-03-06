<?php

namespace OutMart\Models;

use OutMart\Base\ModelBase;
use OutMart\Contracts\Model\IFinalPrice;
use OutMart\Models\Product\Entry;
use OutMart\Models\Traits\HasEntry;

class Product extends ModelBase implements IFinalPrice
{
    use HasEntry;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'catalog_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sku',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
        'discount_price' => 'float',
    ];

    protected $appends = [
        'final_price',
        'discount_value',
    ];

    // public function getProductTypeAttribute($value)
    // {
    //     return match($value) {
    //         ProductType::CONFIGURABLE() => 'configurable',
    //         ProductType::SIMPLE() => 'simple',
    //     };
    // }

    public function getFinalPriceAttribute(): float
    {
        return (float) ($this->discount_price ?? $this->price);
    }

    public function getDiscountValueAttribute()
    {
        $value = $this->price - $this->discount_price;
        return ($value == $this->price) ? 0 : (float) $value;
    }

    public function scopeConfigurableOnly($query)
    {
        return $query->whereNull('configurable_id');
    }

    public function configurable()
    {
        return $this->hasOne(Product::class, 'id', 'configurable_id');
    }

    public function simples()
    {
        return $this->hasMany(Product::class, 'configurable_id', 'id');
    }

    public function entries()
    {
        return $this->hasMany(Entry::class, 'product_id', 'id');
    }
}
