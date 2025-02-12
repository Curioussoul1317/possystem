<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class sales extends Model 
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'invoice_number',
        'subtotal',
        'tax',
        'discount',
        'total',
        'total_cost',
        'payment_status',
        'payment_method',
        'voided_at',
        'sales_type',
        'cart_number',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
         'voided_at' => 'datetime',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_VOIDED = 'voided';
    const STATUS_FAILED = 'failed';

    // Define payment method constants
    const METHOD_CASH = 'cash';
    const METHOD_CARD = 'card';
    const METHOD_BANK_TRANSFER = 'bank_transfer';
    
    // Relationships
    public function customer()
    {
         return $this->belongsTo(customers::class)->withDefault([
            'first_name' => 'Walk-in',
            'last_name' => 'Customer'
        ]); 
    }

    public function items()
    {
        return $this->hasMany(sale_items::class);
    }

    public function inventory()
    {
        return $this->belongsToMany(inventory::class, 'sale_items')
            ->withPivot(['quantity', 'unit_price', 'subtotal'])
            ->withTimestamps();
    }

    // Helper methods
   
    public function calculateTotal()
    {
        $subtotal = $this->items()->sum('subtotal');
        $tax = $subtotal * config('pos.tax_rate', 0.08);
        $total = $subtotal + $tax - ($this->discount ?? 0);

        $this->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ]);

        return $this;
    }


      public function canBeVoided()
    {
        return $this->payment_status !== self::STATUS_VOIDED;
    }

    public static function generateInvoiceNumber()
    {
        $lastSale = self::latest()->first();
        $lastNumber = $lastSale ? intval(substr($lastSale->invoice_number, 3)) : 0;
        return 'INV' . str_pad($lastNumber + 1, 8, '0', STR_PAD_LEFT);
    }
}