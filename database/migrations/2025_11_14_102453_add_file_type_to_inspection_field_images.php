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
        Schema::table('inspection_field_images', function (Blueprint $table) {
            // Add file_type only if not exists
            if (!Schema::hasColumn('inspection_field_images', 'file_type')) {
                $table->enum('file_type', ['image', 'video'])->default('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspection_field_images', function (Blueprint $table) {
            if (Schema::hasColumn('inspection_field_images', 'file_type')) {
                $table->dropColumn('file_type');
            }
        });
    }
};
