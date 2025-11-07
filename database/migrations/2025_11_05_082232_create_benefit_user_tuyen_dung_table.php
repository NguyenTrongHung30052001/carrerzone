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
        Schema::create('benefit_user_tuyen_dung', function (Blueprint $table) {
            // Khóa ngoại liên kết đến bảng 'benefits'
            $table->foreignId('benefit_id')
                  ->constrained('benefits')
                  ->onDelete('cascade');

            // Khóa ngoại liên kết đến bảng 'user_tuyen_dungs'
            $table->foreignId('user_tuyen_dung_id')
                  ->constrained('user_tuyen_dungs')
                  ->onDelete('cascade');

            // Thiết lập khóa chính kép
            $table->primary(['benefit_id', 'user_tuyen_dung_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefit_user_tuyen_dung');
    }
};