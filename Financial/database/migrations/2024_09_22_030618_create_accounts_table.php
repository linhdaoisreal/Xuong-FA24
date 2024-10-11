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
        
        Schema::dropIfExists('accounts');
        
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_number', 20)->unique();
            $table->string('account_name', 50);
            $table->decimal('balance', 15,2)->default(0);
            $table->enum('account_type', ['savings', 'checking', 'creadit']);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
