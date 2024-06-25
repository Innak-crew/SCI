<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        "role",
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class); 
    }

    public function products()
    {
        return $this->hasMany(Products::class); 
    }

    public function customers()
    {
        return $this->hasMany(Customers::class); 
    }

    public function reminders()
    {
        return $this->hasMany(Reminders::class); 
    }

    public function getUser()
    {
        return $this->belongsTo(Customers::class);
    }


}
