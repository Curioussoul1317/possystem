<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
     use HasFactory, SoftDeletes;

    protected $fillable = [
        'amount',
        'interest_rate',
        'loan_date',
        'due_date',
        'status',
        'lender_name',
        'purpose',
        'remaining_amount'
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'remaining_amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(LoanPayment::class);
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments->sum('amount');
    }

    public function getIsOverdueAttribute()
    {
        return $this->status !== 'paid' && $this->due_date < now();
    }
}
