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
        Schema::create('professions', function (Blueprint $table) {
            $table->id();
            $table->string('ten_nganh_nghe');
            
            // Cột xác định đây có phải là Danh mục (cha) hay không
            $table->boolean('is_category')->default(false);

            // Cột tham chiếu 'cha' (tự tham chiếu đến chính bảng này)
            // Cho phép null (vì danh mục cha không có cha)
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('professions') // Tham chiếu đến cột 'id' trên bảng 'professions'
                  ->onDelete('set null'); // Nếu cha bị xóa (dù ta k cho xóa) thì con set null

            $table->string('trang_thai')->default('enable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professions');
    }
};