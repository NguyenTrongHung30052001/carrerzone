<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Quan trọng
use Illuminate\Notifications\Notifiable;

class UserAdmin extends Authenticatable // Quan trọng
{
    use HasFactory, Notifiable;

    protected $table = 'user_admins';

    protected $fillable = [
        'full_name',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}