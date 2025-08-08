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
        Schema::table('brands', function (Blueprint $table) {
            $table->string('slug')->nullable();
            $table->string('image_source')->nullable();
            $table->string('image_thumb')->nullable();
            $table->string('image_optimized')->nullable();
            $table->string('image_original')->nullable();
            $table->string('local_thumb')->nullable();
            $table->string('local_optimized')->nullable();
            $table->string('local_original')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
             $table->dropColumn('slug');
             $table->dropColumn('image_source');
             $table->dropColumn('image_thumb');
             $table->dropColumn('image_optimized');
             $table->dropColumn('image_original');
             $table->dropColumn('local_thumb');
             $table->dropColumn('local_optimized');
             $table->dropColumn('local_original');
        });
    }
};
