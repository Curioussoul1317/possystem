<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class categories extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 
    ];

     public function products()
    {
        return $this->hasMany(inventory::class);
    }
}
