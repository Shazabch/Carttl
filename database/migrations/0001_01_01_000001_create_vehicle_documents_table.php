<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vehicle_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_id')->nullable();
            $table->string('file_path');
            $table->string('type');
            $table->date('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('vehicle_documents');
    }
};
