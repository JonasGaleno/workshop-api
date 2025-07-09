<?php

namespace App\Models\Stock;

use App\Models\Finance\PaymentMethod;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'purchase_payment_methods';
    protected $fillable = [
        'purchase_id',
        'payment_method_id',
        'description',
        'total_value',
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

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
