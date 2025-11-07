<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;

    protected $fillable = [
        'ten_nganh_nghe',
        'is_category', // (boolean 0 hoặc 1)
        'parent_id',   // (null nếu là category, hoặc id của category cha)
        'trang_thai',
    ];

    /**
     * Chuyển kiểu dữ liệu cho cột 'is_category' thành boolean.
     */
    protected $casts = [
        'is_category' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships (Mối quan hệ)
    |--------------------------------------------------------------------------
    */

    /**
     * Lấy danh mục Cha (nếu đây là ngành nghề con).
     */
    public function parent()
    {
        // Một ngành nghề (con) thuộc về một ngành nghề (cha)
        return $this->belongsTo(Profession::class, 'parent_id');
    }

    /**
     * Lấy các ngành nghề Con (nếu đây là danh mục cha).
     */
    public function children()
    {
        // Một ngành nghề (cha) có nhiều ngành nghề (con)
        return $this->hasMany(Profession::class, 'parent_id');
    }
}