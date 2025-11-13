<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('delivery_type')->nullable(); 
            $table->decimal('delivery_charges', 10, 2)->nullable();
            $table->string('address')->nullable();
            $table->string('receiver_name')->nullable();
            $table->string('receiver_email')->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->string('status')->nullable(); 
            
            $table->json('services')->nullable();    
            $table->json('fixed_fees')->nullable();  

            // New columns
            $table->string('payment_screenshot')->nullable();
            $table->string('emirate_id_front')->nullable();
            $table->string('emirate_id_back')->nullable();
            $table->string('current_location')->nullable();
            $table->string('delivery_location')->nullable();
            $table->string('location')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
