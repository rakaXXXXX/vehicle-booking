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
        Schema::create('fuel_logs', function (Blueprint $table) {
            $table->id();
$table->unsignedBigInteger('vehicle_id')->index();
$table->unsignedBigInteger('booking_id')->nullable()->index();
            $table->decimal('fuel_amount', 8, 2);
            $table->decimal('fuel_cost', 10, 2)->nullable();
            $table->integer('odometer');
$table->unsignedBigInteger('created_by')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_logs');
    }
};
