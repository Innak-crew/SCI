<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryKey extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'general_key'];

    public function designs()
    {
        return $this->hasMany(Designs::class);
    }
}
