<?php

namespace App\Models\Finance;

use App\Models\Company\Company;
use App\Models\Sale\EstimatePaymentMethod;
use App\Models\Sale\WorkOrderPaymentMethod;
use App\Models\Stock\PurchasePaymentMethod;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';
    protected $fillable = [
        'description',
        'type',
        'is_active',
        'company_id',
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

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function estimates()
    {
        return $this->hasMany(EstimatePaymentMethod::class);
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrderPaymentMethod::class);
    }

    public function purchases()
    {
        return $this->hasMany(PurchasePaymentMethod::class);
    }
}
