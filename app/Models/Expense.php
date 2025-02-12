<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
     use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'amount',
        'category',
        'expense_date',
        'payment_method',
        'receipt_url',
        'notes'
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
