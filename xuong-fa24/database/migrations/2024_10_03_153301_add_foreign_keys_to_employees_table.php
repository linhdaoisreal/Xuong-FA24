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
        Schema::table('employees', function (Blueprint $table) {
            // Thêm khóa ngoại cho cột department_id
            $table->unsignedBigInteger('department_id')->change();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');

            // Thêm khóa ngoại cho cột manager_id
            $table->unsignedBigInteger('manager_id')->change();
            $table->foreign('manager_id')->references('id')->on('managers')->onDelete('cascade');

            Schema::table('employees', function (Blueprint $table) {
                DB::statement('ALTER TABLE employees MODIFY profile_picture MEDIUMBLOB');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('employees', function (Blueprint $table) {
            // Xóa các khóa ngoại nếu rollback
            $table->dropForeign(['department_id']);
            $table->dropForeign(['manager_id']);
        });
    }
};
