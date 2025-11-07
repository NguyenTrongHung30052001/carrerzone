<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    /**
     * Các cột được phép gán hàng loạt.
     */
    protected $fillable = [
        'user_tuyen_dung_id',
        'chuc_danh',
        'profession_id',
        'province_id',
        'ward_id',
        'dia_chi_lam_viec',
        'mo_ta_cong_viec',
        'yeu_cau_cong_viec',
        'luong_currency',
        'luong_min',
        'luong_max',
        'hien_thi_luong',
        'hinh_thuc_lam_viec',
        'han_chot_nop_ho_so',
        'yeu_cau_thu_gioi_thieu',
        'ngon_ngu_ho_so',
        'gioi_tinh',
        'tuoi_min',
        'tuoi_max',
        'kinh_nghiem',
        'cap_bac',
        'bang_cap',
        'ten_cong_ty',
        'dia_chi_cong_ty',
        'ten_nguoi_lien_he',
        'email_lien_he',
        'thong_tin_khac',
    ];

    /**
     * Chuyển kiểu dữ liệu tự động.
     * Rất quan trọng cho các cột 'json' (chọn nhiều).
     */
    protected $casts = [
        'hinh_thuc_lam_viec' => 'json',
        'ngon_ngu_ho_so' => 'json',
        'han_chot_nop_ho_so' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships (Mối quan hệ)
    |--------------------------------------------------------------------------
    */

    /**
     * Lấy nhà tuyển dụng (chủ sở hữu) của tin đăng này.
     */
    public function userTuyenDung()
    {
        return $this->belongsTo(UserTuyenDung::class, 'user_tuyen_dung_id');
    }

    /**
     * Lấy ngành nghề của tin đăng này.
     */
    public function profession()
    {
        return $this->belongsTo(Profession::class, 'profession_id');
    }

    /**
     * Lấy tỉnh/thành phố của nơi làm việc.
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    /**
     * Lấy xã/phường của nơi làm việc.
     */
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    /**
     * Tự động gán user_tuyen_dung_id khi tạo mới.
     * (Sử dụng 'boot' method)
     */
    protected static function boot()
    {
        parent::boot();

        // Tự động gán ID của nhà tuyển dụng đang đăng nhập
        // khi một tin đăng mới được 'creating' (đang tạo).
        static::creating(function ($post) {
            // Đảm bảo chỉ gán nếu user là 'tuyen_dung' và đã đăng nhập
            if (Auth::guard('tuyen_dung')->check()) {
                $post->user_tuyen_dung_id = Auth::guard('tuyen_dung')->id();
            }
        });
    }
}