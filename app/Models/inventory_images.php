<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class inventory_images extends Model
{
       use HasFactory;

    protected $fillable = [
        'inventory_id',
        'image_path',
        'is_primary',
        'sort_order'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    // When setting a new primary image, remove primary status from others
    public function setPrimary()
    {
        $this->inventory->images()->where('id', '!=', $this->id)
            ->update(['is_primary' => false]);
        $this->is_primary = true;
        $this->save();
    }
}
