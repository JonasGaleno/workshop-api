<?php

namespace App\Models\Product;

use App\Models\Sale\Tax;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Cache;

class ProductTax extends Pivot
{
    protected $table = 'product_taxes';
    protected $fillable = [
        'tax_id',
        'product_id',
        'uf',
        'created_by',
        'updated_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    protected static function booted()
    {
        static::saved(function ($productTax) {
            Cache::forget("product_tax_{$productTax->id}");
            Cache::tags(['products_taxes'])->flush();
        });

        static::deleted(function ($productTax) {
            Cache::forget("product_tax_{$productTax->id}");
            Cache::tags(['products_taxes'])->flush();
        });
    }
}
