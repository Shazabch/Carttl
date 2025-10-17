<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vehicle_features', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_id')->nullable();
            $table->integer('feature_id')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('vehicle_features');
    }
};
