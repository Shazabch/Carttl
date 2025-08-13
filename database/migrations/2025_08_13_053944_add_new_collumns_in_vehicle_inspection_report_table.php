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
        Schema::table('vehicle_inspection_reports', function (Blueprint $table) {
             $table->string('is_inspection')->nullable();
             $table->string('gearshifting')->nullable();
             $table->string('remarks')->nullable();
             $table->string('comment_section1')->nullable();
             $table->string('comment_section2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_inspection_reports', function (Blueprint $table) {
            $table->dropColumn('is_inspection');
            $table->dropColumn('gearshifting');
            $table->dropColumn('remarks');
            $table->dropColumn('comment_section1');
            $table->dropColumn('comment_section2');
        });
    }
};
