<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vehicle_videos', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_id')->nullable();
            $table->string('video_url');
            $table->enum('type', ['youtube', 'vimeo', 'self-hosted'])->default('youtube');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('vehicle_videos');
    }
};
