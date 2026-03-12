<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate')->unique();
            $table->string('brand');
            $table->string('model')->nullable();
            $table->enum('type', ['passenger', 'cargo']);
            $table->enum('ownership', ['company', 'rental']);
            $table->string('rental_company')->nullable();
            $table->date('rental_expiry')->nullable();
            $table->foreignId('region_id')
                  ->constrained('regions')
                  ->cascadeOnDelete(); // Hapus vehicle jika region dihapus
            $table->decimal('fuel_consumption', 5, 2)->nullable();
            $table->date('last_service_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->enum('status', ['available', 'in_use', 'maintenance', 'unavailable'])->default('available');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};