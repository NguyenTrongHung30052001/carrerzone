<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Đổi tên bảng từ 'users' thành 'user_ung_vien'
        Schema::create('user_ung_vien', function (Blueprint $table) {
            $table->id();
            $table->string('ho_va_ten_lot'); // Cột mới
            $table->string('ten');           // Cột mới
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // (Bạn có thể xóa các file migration khác như password_resets, failed_jobs nếu muốn)
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_ung_vien');
    }
};