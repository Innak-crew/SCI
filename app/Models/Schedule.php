<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedule';

    protected $fillable = [
        'user_id ',
        'order_id ',
        'title',
        'description',
        "start",
        'end',
        'visibility',
        'is_editable',
        'status',
        "level",
        "updater_admin_or_manager_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
