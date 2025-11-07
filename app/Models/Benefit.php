<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;

    /**
     * Các cột được phép gán hàng loạt.
     */
    protected $fillable = [
        'ten_phuc_loi',
        'trang_thai',
    ];
}