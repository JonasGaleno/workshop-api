<?php

namespace App\Models\Sale;

use App\Models\Company\Company;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $fillable = [
        'work_order_id',
        'nf_number',
        'serie',
        'issue_date',
        'total_value',
        'access_key',
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

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
