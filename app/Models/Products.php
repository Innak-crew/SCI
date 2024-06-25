<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'image_url',
        'dimensions',
        'type',
        'unit_id',
        'rate_per',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(QuantityUnits::class)->first();
    }

    public function catagories()
    {
        return $this->belongsTo(Categories::class)->first();
    }

}
