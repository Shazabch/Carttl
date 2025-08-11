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
        Schema::create('vehicle_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('brand_id')->nullable();
            $table->string('make_id')->nullable();
            $table->string('mileage')->nullable();
            $table->string('year')->nullable();
            $table->string('specification')->nullable();
            $table->string('faq')->nullable();
            $table->string('type')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_enquiries');
    }
};
