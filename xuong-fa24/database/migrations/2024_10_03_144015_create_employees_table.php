<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('first_name', 100);  // Tên nhân viên
            $table->string('last_name', 100);   // Họ nhân viên
            $table->string('email', 150)->unique(); // Email (duy nhất)
            $table->string('phone', 15);        // Số điện thoại
            $table->date('date_of_birth');      // Ngày sinh
            $table->dateTime('hire_date');      // Ngày thuê
            $table->decimal('salary', 10, 2);   // Lương
            $table->boolean('is_active')->default(1); // Trạng thái hoạt động
            $table->unsignedBigInteger('department_id'); // Mã phòng ban
            $table->unsignedBigInteger('manager_id');    // Mã quản lý
            $table->text('address');           // Địa chỉ
            $table->binary('profile_picture'); // Ảnh đại diện

            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
