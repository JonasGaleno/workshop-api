<?php

namespace App\Models\Sale;

use App\Models\Finance\PaymentMethod;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderPaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'work_order_payment_methods';
    protected $fillable = [
        'work_order_id',
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

    public function workOrder()
    {
        return $this->belongsTo(Estimate::class, 'work_order_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
