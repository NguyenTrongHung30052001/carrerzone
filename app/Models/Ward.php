<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        'ten_xa_phuong',
        'trang_thai',
        'id_parent',
    ];

    /**
     * Một Xã thuộc về một Tỉnh
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'id_parent');
    }
}