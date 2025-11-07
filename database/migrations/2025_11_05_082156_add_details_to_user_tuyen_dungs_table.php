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
        Schema::table('user_tuyen_dungs', function (Blueprint $table) {
            // Thêm các cột mới sau cột 'password'
            $table->string('total_employees')->nullable()->after('password');
            $table->string('operation_type')->nullable()->after('total_employees');
            $table->string('website')->nullable()->after('operation_type');
            $table->string('tax_code')->nullable()->after('website');
            $table->string('logo')->nullable()->after('tax_code'); // Path to logo
            $table->text('company_introduction')->nullable()->after('logo');
            $table->text('company_message')->nullable()->after('company_introduction');
            
            // Contact Person
            $table->string('contact_name')->nullable()->after('company_message');
            $table->string('contact_position')->nullable()->after('contact_name');

            // Location
            // Liên kết với bảng 'provinces'
            $table->foreignId('province_id')->nullable()->after('contact_position')->constrained('provinces');
            // Liên kết với bảng 'wards'
            $table->foreignId('ward_id')->nullable()->after('province_id')->constrained('wards');
            
            $table->string('address')->nullable()->after('ward_id'); // Địa chỉ chi tiết (số nhà, tên đường)
            $table->string('phone')->nullable()->after('address');
            $table->string('fax')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_tuyen_dungs', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
            $table->dropForeign(['ward_id']);
            
            $table->dropColumn([
                'total_employees',
                'operation_type',
                'website',
                'tax_code',
                'logo',
                'company_introduction',
                'company_message',
                'contact_name',
                'contact_position',
                'province_id',
                'ward_id',
                'address',
                'phone',
                'fax',
            ]);
        });
    }
};