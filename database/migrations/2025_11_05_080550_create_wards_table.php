<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wards', function (Blueprint $table) {
            $table->id();
            $table->string('ten_xa_phuong');
            $table->string('trang_thai')->default('enable');
            
            // Liên kết 'id_parent' với bảng 'provinces'
            $table->foreignId('id_parent')
                  ->constrained('provinces')
                  ->onDelete('cascade'); // Nếu tỉnh bị xóa, xã cũng bị xóa
                  
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wards');
    }
};