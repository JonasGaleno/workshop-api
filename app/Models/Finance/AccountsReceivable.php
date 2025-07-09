<?php

namespace App\Models\Finance;

use App\Models\Company\Company;
use App\Models\People\People;
use App\Models\Sale\Invoice;
use App\Models\Sale\WorkOrder;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsReceivable extends Model
{
    use HasFactory;

    protected $table = 'accounts_receivable';
    protected $fillable = [
        'installment_number',
        'person_id',
        'work_order_id',
        'invoice_id',
        'description',
        'discount',
        'interest',
        'received_value',
        'total_value',
        'expire_date',
        'payment_date',
        'status',
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

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function financialTransactions()
    {
        return $this->hasMany(FinancialTransaction::class);
    }
}
