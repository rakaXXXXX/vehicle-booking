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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
$table->unsignedBigInteger('vehicle_id')->nullable()->index();
$table->unsignedBigInteger('driver_id')->nullable()->index();
            $table->unsignedBigInteger('approver_level_1_id')->nullable()->index();
            $table->unsignedBigInteger('approver_level_2_id')->nullable()->index();
            $table->unsignedBigInteger('requester_id')->index();
            $table->text('purpose');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('start_odometer')->nullable();
            $table->integer('end_odometer')->nullable();
            $table->decimal('fuel_used', 8, 2)->nullable();
            $table->enum('status', ['pending', 'approved_level_1', 'approved', 'rejected', 'completed', 'cancelled'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
