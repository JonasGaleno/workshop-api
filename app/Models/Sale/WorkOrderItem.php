<?php

namespace App\Models\Sale;

use App\Models\Company\Employee;
use App\Models\Product\Product;
use App\Models\Service\Service;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderItem extends Model
{
    use HasFactory;

    protected $table = 'work_order_items';
    protected $fillable = [
        'item',
        'work_order_id',
        'service_id',
        'product_id',
        'employee_id',
        'description',
        'amount',
        'unit_value',
        'discount',
        'discount_perc',
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
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
