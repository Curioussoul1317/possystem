<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class carts extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_number',
        'customer_id',
        'status',
        'total'
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $enums = [
        'status' => [
            'neworder',
            'processing',
            'paid',
            'delivered',
            'cancelled'
        ]
    ];

    /**
     * Get the customer that owns the cart.
     */
    public function customer()
    {
        return $this->belongsTo(customers::class);
    }

        

    /**
     * Get the items in the cart.
     */
    public function items()
    {
        return $this->hasMany(cart_items::class);
    }

    /**
     * Calculate the total of all items in the cart.
     */
    public function calculateTotal(): void
    {
        $this->total = $this->items->sum('subtotal');
        $this->save();
    }

    public static function generateInvoiceNumber()
    {
        $lastSale = self::latest()->first();
        $lastNumber = $lastSale ? intval(substr($lastSale->invoice_number, 3)) : 0;
        return 'CART' . str_pad($lastNumber + 1, 8, '0', STR_PAD_LEFT);
    }
}