<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class cart_items extends Model
{
     use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
        'subtotal'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Get the cart that owns the item.
     */
    public function cart() 
    {
        return $this->belongsTo(carts::class);
    }

    /**
     * Get the product associated with the cart item.
     */
    public function product() 
    {
        return $this->belongsTo(inventory::class);
    }

    /**
     * Calculate the subtotal for this item.
     */
    public function calculateSubtotal(): void
    {
        $this->subtotal = $this->price * $this->quantity;
        $this->save();
    }

    /**
     * Update quantity and recalculate subtotal
     */
    public function updateQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
        $this->calculateSubtotal();
        $this->cart->calculateTotal();
    }

    protected static function booted()
    {
        static::created(function ($cartItem) {
            $cartItem->cart->calculateTotal();
        });

        static::updated(function ($cartItem) {
            $cartItem->cart->calculateTotal();
        });

        static::deleted(function ($cartItem) {
            $cartItem->cart->calculateTotal();
        });
    }
}