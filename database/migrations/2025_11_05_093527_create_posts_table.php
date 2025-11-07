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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại: Tin đăng này thuộc về nhà tuyển dụng nào
            $table->foreignId('user_tuyen_dung_id')
                  ->constrained('user_tuyen_dungs')
                  ->onDelete('cascade');

            $table->string('chuc_danh_tuyen_dung');

            // Khóa ngoại: Ngành nghề (1 tin đăng chỉ thuộc 1 ngành)
            $table->foreignId('profession_id')
                  ->constrained('professions')
                  ->onDelete('restrict'); // Không cho xóa ngành nghề nếu đang có tin đăng

            // Nơi làm việc
            $table->foreignId('province_id')->constrained('provinces');
            $table->foreignId('ward_id')->constrained('wards');
            $table->string('dia_chi_lam_viec'); // Tự nhập (số nhà, tên đường)

            $table->text('mo_ta_cong_viec');
            $table->text('yeu_cau_cong_viec');

            // Lương
            $table->string('luong_currency', 10)->default('VND'); // 'VND' hoặc 'USD'
            $table->decimal('luong_from', 15, 2)->nullable(); // 15 chữ số, 2 chữ số thập phân
            $table->decimal('luong_to', 15, 2)->nullable();
            $table->string('luong_hien_thi')->default('co'); // 'co', 'khong'

            // Hình thức (lưu dạng JSON vì có thể chọn nhiều)
            $table->json('hinh_thuc'); // ['nhan_vien_chinh_thuc', 'ban_thoi_gian', ...]

            $table->date('han_chot_nhan_ho_so');

            // Thư giới thiệu
            $table->string('yeu_cau_thu_gioi_thieu')->default('khong_hien_thi'); // 'bat_buoc', 'hien_thi_khong_bat_buoc', 'khong_hien_thi'

            // Ngôn ngữ hồ sơ (lưu dạng JSON vì có thể chọn nhiều)
            $table->json('ngon_ngu_ho_so'); // ['Tieng Anh', 'Tieng Viet', ...]

            // Yêu cầu khác
            $table->string('gioi_tinh')->default('nam/nu'); // 'nam/nu', 'nam', 'nu'
            $table->unsignedTinyInteger('tuoi_from')->nullable();
            $table->unsignedTinyInteger('tuoi_to')->nullable();
            $table->string('kinh_nghiem'); // Sẽ lưu text: 'Không yêu cầu kinh nghiệm', 'Có kinh nghiệm', ...
            $table->string('cap_bac'); // Sẽ lưu text: 'Sinh viên/ Thực tập sinh', ...
            $table->string('bang_cap'); // Sẽ lưu text: 'Không yêu cầu bằng cấp', ...

            // Thông tin công ty (lấy từ tài khoản đăng)
            $table->string('ten_cong_ty');
            $table->string('dia_chi_cong_ty'); // Lưu text tỉnh/thành

            // Thông tin liên hệ (lấy từ tài khoản đăng)
            $table->string('nguoi_lien_he');
            $table->string('email_lien_he');
            
            $table->text('thong_tin_khac')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};