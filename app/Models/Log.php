<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

     protected $table = 'logs';

     protected $fillable = [
         'message', 'level', 'type', 'created_at'
     ];
}
