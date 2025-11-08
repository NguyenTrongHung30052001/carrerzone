<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import Str facade

class Profession extends Model
{
    use HasFactory;

    protected $fillable = [
        'ten_nganh_nghe',
        'is_category',
        'parent_id',
        'trang_thai',
        'slug', // Thêm slug vào fillable
    ];

    /**
     * Tự động tạo slug khi lưu.
     * Sử dụng 'booted' method (cách làm mới và chuẩn)
     */
    protected static function booted()
    {
        static::creating(function ($profession) {
            $profession->slug = Str::slug($profession->ten_nganh_nghe);
        });

        static::updating(function ($profession) {
            $profession->slug = Str::slug($profession->ten_nganh_nghe);
        });
    }

    /**
     * Quan hệ: Lấy danh mục cha (nếu có)
     */
    public function parent()
    {
        return $this->belongsTo(Profession::class, 'parent_id');
    }

    /**
     * Quan hệ: Lấy các ngành nghề con (nếu là danh mục cha)
     */
    public function children()
    {
        return $this->hasMany(Profession::class, 'parent_id');
    }

    /**
     * Quan hệ: Lấy các bài đăng (posts) thuộc về ngành nghề này
     * (Để đếm số lượng tin đăng)
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'profession_id');
    }
}