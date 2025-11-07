<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Quan trọng
use Illuminate\Notifications\Notifiable;
use App\Http\Controllers\UserDashboardController;

class UserTuyenDung extends Authenticatable // Quan trọng
{
    use HasFactory, Notifiable;

    protected $table = 'user_tuyen_dungs';

    /**
     * Các cột được phép gán hàng loạt (ĐÃ CẬP NHẬT).
     */
    protected $fillable = [
        'ten_cong_ty',
        'email',
        'password',
        // Các cột mới
        'total_employees',
        'operation_type',
        'website',
        'tax_code',
        'logo',
        'company_introduction',
        'company_message',
        'contact_name',
        'contact_position',
        'province_id',
        'ward_id',
        'address',
        'phone',
        'fax',
    ];

    /**
     * Các cột nên được ẩn.
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

    /*
    |--------------------------------------------------------------------------
    | Relationships (Mối quan hệ)
    |--------------------------------------------------------------------------
    */

    /**
     * Lấy Tỉnh/Thành phố của nhà tuyển dụng.
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    /**
     * Lấy Xã/Phường của nhà tuyển dụng.
     */
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    /**
     * Lấy các phúc lợi (benefits) của nhà tuyển dụng.
     * Đây là mối quan hệ Nhiều-Nhiều (belongsToMany)
     */
    public function benefits()
    {
        return $this->belongsToMany(
            Benefit::class,
            'benefit_user_tuyen_dung', // Tên bảng trung gian
            'user_tuyen_dung_id',      // Khóa ngoại của model này
            'benefit_id'               // Khóa ngoại của model liên kết
        );
    }
    
}