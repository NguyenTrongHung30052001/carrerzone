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
        Schema::table('professions', function (Blueprint $table) {
            // Thêm cột 'slug' sau cột 'ten_nganh_nghe'
            // 'unique()' để đảm bảo không có 2 ngành nghề trùng URL
            $table->string('slug')->unique()->nullable()->after('ten_nganh_nghe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professions', function (Blueprint $table) {
            // Xóa cột 'slug' nếu rollback
            $table->dropColumn('slug');
        });
    }
};