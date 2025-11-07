<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Province extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'ten_tinh_thanh_pho',
        'trang_thai',
    ];

    /**
     * Một Tỉnh có nhiều Xã
     */
    public function wards()
    {
        return $this->hasMany(Ward::class, 'id_parent');
    }
}