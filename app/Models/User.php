<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Chỉ định bảng mà model này sử dụng.
     */
    protected $table = 'user_ung_vien';

    /**
     * Các cột được phép gán hàng loạt.
     */
    protected $fillable = [
        'ho_va_ten_lot',
        'ten',
        'email',
        'password',
    ];

    /**
     * Các cột nên được ẩn khi chuyển sang JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Các cột nên được chuyển kiểu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}