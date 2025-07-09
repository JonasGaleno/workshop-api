<?php

namespace App\Models\Finance;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    use HasFactory;

    protected $table = 'financial_transactions';
    protected $fillable = [
        'account_receivable_id',
        'account_payable_id',
        'payment_method_id',
        'payment_date',
        'amount_paid',
        'discount',
        'interest',
        'observation',
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

    public function accountReceivable()
    {
        return $this->belongsTo(AccountsReceivable::class, 'account_receivable_id');
    }

    public function accountPayable()
    {
        return $this->belongsTo(AccountsPayable::class, 'account_payable_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
