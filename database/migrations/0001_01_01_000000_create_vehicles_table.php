<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('brand_id')->nullable();
            $table->integer('model_id')->nullable();
            $table->string('variant')->nullable();
            $table->year('year');
            $table->integer('body_type_id')->nullable();
            $table->integer('fuel_type_id')->nullable();
            $table->integer('transmission_id')->nullable();
            $table->integer('mileage');
            $table->integer('engine_cc')->nullable();
            $table->integer('horsepower')->nullable();
            $table->string('torque')->nullable();
            $table->tinyInteger('seats')->nullable();
            $table->tinyInteger('doors')->nullable();
            $table->string('color')->nullable();
            $table->string('interior_color')->nullable();
            $table->enum('drive_type', ['FWD', 'RWD', 'AWD', '4WD'])->nullable();
            $table->string('vin')->nullable();
            $table->string('registration_no')->nullable();
            $table->decimal('price', 12, 2);
            $table->boolean('negotiable')->default(false);
            $table->enum('condition', ['new', 'used', 'certified'])->default('used');
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'published', 'sold', 'pending'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('vehicles');
    }
};
