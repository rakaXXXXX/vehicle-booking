<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('full_name');
            $table->string('nip')->unique()->nullable();
            $table->string('position')->nullable();
            $table->foreignId('region_id')->nullable()
                  ->constrained('regions') // Ini akan mereferensi ke tabel regions
                  ->nullOnDelete(); // Set null jika region dihapus
            $table->enum('role', ['admin', 'approver_level_1', 'approver_level_2', 'employee'])->default('employee');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};