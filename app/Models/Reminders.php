<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminders extends Model
{
    use HasFactory;

    protected $table = 'reminders';

    protected $fillable = [
        'user_id ',
        'title',
        'description',
        "reminder_time",
        'is_completed',
        'priority',
        'category',
        'repeat',
        "notes",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
