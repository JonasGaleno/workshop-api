<?php

namespace App\Models\Stock;

use App\Models\Company\Company;
use App\Models\Finance\PaymentMethod;
use App\Models\People\People;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchases';
    protected $fillable = [
        'person_id',
        'payment_method_id',
        'issue_date',
        'delivery_date',
        'status',
        'total_value',
        'company_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function people()
    {
        return $this->belongsTo(People::class, 'person_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function paymentMethods()
    {
        return $this->hasMany(PurchasePaymentMethod::class);
    }
}
