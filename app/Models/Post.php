<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * Các cột được phép gán hàng loạt.
     */
    protected $fillable = [
        'user_tuyen_dung_id',
        'chuc_danh',
        'profession_id', // ID Ngành nghề
        'province_id',   // ID Tỉnh/Thành làm việc
        'ward_id',       // ID Xã/Phường làm việc
        'dia_chi_lam_viec',       // Địa chỉ cụ thể nơi làm việc
        'mo_ta_cong_viec',
        'yeu_cau_cong_viec',
        'luong_currency', // Loại tiền tệ (VND, USD)
        'luong_from',     // Lương từ
        'luong_to',       // Lương đến
        'luong_hien_thi', // Có hiển thị lương không (boolean)
        'hinh_thuc',      // Hình thức làm việc (JSON array)
        'han_chot_nop_ho_so',
        'yeu_cau_thu_gioi_thieu',
        'ngon_ngu_ho_so', // Ngôn ngữ hồ sơ (JSON array)
        'gioi_tinh',
        'tuoi_from',      // Tuổi từ
        'tuoi_to',        // Tuổi đến
        'kinh_nghiem',
        'cap_bac',
        'bang_cap',
        'ten_cong_ty',      // Tên công ty (lưu cứng tại thời điểm đăng)
        'dia_chi_cong_ty',  // Địa chỉ công ty (lưu cứng)
        'nguoi_lien_he',    // Người liên hệ (lưu cứng)
        'email_lien_he',    // Email liên hệ (lưu cứng)
        'thong_tin_khac',
        // Các cột bổ sung để hiển thị nhanh
        'province_name',
        'ward_name',
    ];

    /**
     * Định kiểu dữ liệu cho các cột.
     */
    protected $casts = [
        'hinh_thuc' => 'array',        // Tự động chuyển JSON sang mảng PHP
        'ngon_ngu_ho_so' => 'array',   // Tự động chuyển JSON sang mảng PHP
        'han_chot_nop_ho_so' => 'date',
        'luong_hien_thi' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships (Mối quan hệ)
    |--------------------------------------------------------------------------
    */

    /**
     * Tin đăng thuộc về một Nhà tuyển dụng.
     */
    public function employer()
    {
        return $this->belongsTo(UserTuyenDung::class, 'user_tuyen_dung_id');
    }

    /**
     * Tin đăng thuộc về một Ngành nghề.
     */
    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    /**
     * Tin đăng thuộc về một Tỉnh/Thành phố (nơi làm việc).
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Tin đăng thuộc về một Xã/Phường (nơi làm việc).
     */
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}