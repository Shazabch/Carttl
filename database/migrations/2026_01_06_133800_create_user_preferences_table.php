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
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->decimal('price_to')->nullable();
            $table->decimal('price_from')->nullable();
            $table->string('date_to')->nullable();
            $table->string('date_form')->nullable();
            $table->string('mileage_to')->nullable();
            $table->string('mileage_form')->nullable();
            $table->string('body_type')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('year_to')->nullable();
            $table->string('year_form')->nullable();
            $table->string('specs')->nullable();
            $table->string('location')->nullable();
            $table->json('additional_filters')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
