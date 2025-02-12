<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
     use HasFactory;

    protected $fillable = [
        'loan_id',
        'amount',
        'payment_date',
        'payment_method',
        'reference_number'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
