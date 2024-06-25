<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        "phone",
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUser()
    {
        return $this->hasMany(User::class); 
    }
}
