<?php

namespace App\Models\Sale;

use App\Models\Finance\PaymentMethod;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimatePaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'estimate_payment_methods';
    protected $fillable = [
        'estimate_id',
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

    public function estimate()
    {
        return $this->belongsTo(Estimate::class, 'estimate_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
