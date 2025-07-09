<?php

namespace App\Models\Sale;

use App\Models\Company\Company;
use App\Models\Company\Employee;
use App\Models\Finance\PaymentMethod;
use App\Models\People\People;
use App\Models\People\Vehicle;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    use HasFactory;

    protected $table = 'estimates';
    protected $fillable = [
        'vehicle_id',
        'person_id',
        'employee_id',
        'payment_method_id',
        'multi_employee',
        'total_value',
        'status',
        'expire_date',
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

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function people()
    {
        return $this->belongsTo(People::class, 'person_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
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
        return $this->hasMany(EstimatePaymentMethod::class);
    }
}
