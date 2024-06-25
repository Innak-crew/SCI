<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuantityUnits extends Model
{
    use HasFactory;

    protected $table = 'quantity_units';

    protected $fillable = [
        'name',
        'description',
    ];

    public function unit($id)
    {
        return QuantityUnits::find($id);
    }
}
