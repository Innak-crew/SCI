<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'type',
    ];

    public function orderItems(){
        return $this->hasMany(OrderItems::class);
    }

    public function parentCategory()
    {
        return $this->belongsTo(Categories::class, 'parent_id');
    }

    public function subCategories()
    {
        return $this->hasMany(Categories::class, 'parent_id');
    }
}
 