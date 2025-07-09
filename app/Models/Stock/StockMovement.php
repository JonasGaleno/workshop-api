<?php

namespace App\Models\Stock;

use App\Models\Product\Product;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $table = 'stock_movements';
    protected $fillable = [
        'mov_type',
        'amount',
        'mov_date',
        'origin_id',
        'origin',
        'obs',
        'product_id',
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

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}