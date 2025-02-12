<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class inventory extends Model
{
      use HasFactory, SoftDeletes;

    protected $table = 'inventories';

    protected $fillable = [
            'item_code',
            'barcode',
            'name',
            'brand_id',      
            'category_id', 
            'description',
            'gender',
            'age',
            'colour',
            'volume', 
            'unit_cost',  
            'unit_price',  
            'stock_quantity',  
            'discount_percentage'
    ]; 

    protected $casts = [
        'unit_price' => 'decimal:2',
        'active' => 'boolean',
    ];

    // Relationships
    public function images()
    {
        return $this->hasMany(inventory_images::class);
    }

    public function sales()
    {
        return $this->belongsToMany(sales::class, 'sale_items')
            ->withPivot(['quantity', 'unit_price', 'subtotal'])
            ->withTimestamps();
    }

    // Helper methods
    public function getPrimaryImage()
    {
        return $this->images()->where('is_primary', true)->first();
    }

    public function updateStock($quantity, $operation = 'subtract')
    {
        if ($operation === 'add') {
            $this->stock_quantity += $quantity;
        } else {
            $this->stock_quantity -= $quantity;
        }
        $this->save();
    }

        public function brand()
    {
        return $this->belongsTo(brands::class);
    }

    public function category()
    {
        return $this->belongsTo(categories::class);
    }

        public function scopeByBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByCategoryAndChildren($query, categories $category)
    {
        $categoryIds = [$category->id];
        $category->allChildren->each(function ($child) use (&$categoryIds) {
            $categoryIds[] = $child->id;
        });
        
        return $query->whereIn('category_id', $categoryIds);
    }
}
