<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

 
class sale_items extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sales_id',
        'inventory_id',
        'quantity',
        'unit_price',
        'subtotal'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relationships
    public function sale()
    {
        return $this->belongsTo(sales::class);
    }

    public function inventory()
    {
        return $this->belongsTo(inventory::class);
    }

    // Automatically calculate subtotal before saving
   protected static function boot()
    {
        parent::boot();

        static::creating(function ($saleItem) {
            $saleItem->subtotal = $saleItem->quantity * $saleItem->unit_price;
        });

        static::created(function ($saleItem) {
            // Update inventory stock
            if ($saleItem->inventory) {
                $saleItem->inventory->updateStock($saleItem->quantity);
            }
            
            // Recalculate sale total if sale exists
            if ($saleItem->sale) {
                $sale = $saleItem->sale;
                $subtotal = $sale->items->sum('subtotal');
                $tax = $subtotal * config('pos.tax_rate', 0.1);
                $total = $subtotal + $tax;

                $sale->update([
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'total' => $total
                ]);
            }
        });
    }
}
