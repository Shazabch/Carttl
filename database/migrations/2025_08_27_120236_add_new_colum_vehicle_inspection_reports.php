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
            $table->string('soft_door_closing')->nullable();
            $table->text('final_conclusion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_inspection_reports', function (Blueprint $table) {
             $table->dropColumn('soft_door_closing');
             $table->dropColumn('final_conclusion');

        });
    }
};
