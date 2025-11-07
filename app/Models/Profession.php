<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profession extends Model
{
    use HasFactory;

    /**
     * Các cột được phép gán hàng loạt.
     */
    protected $fillable = [
        'ten_nganh_nghe',
        'is_category',
        'parent_id',
        'trang_thai',
    ];

    
    protected $casts = [
        'is_category' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Profession::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Profession::class, 'parent_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'profession_id');
    }
}