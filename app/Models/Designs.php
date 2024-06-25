<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designs extends Model
{
    use HasFactory;

    protected $table = 'designs';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'category_id',
        'category_key_id',
        'image_url',
        'product_id',
        'type',
        'unit_id',
    ];

    public function unit()
    {
        return $this->belongsTo(QuantityUnits::class, 'unit_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function categoryKey()
    {
        return $this->belongsTo(CategoryKey::class);
    }
}