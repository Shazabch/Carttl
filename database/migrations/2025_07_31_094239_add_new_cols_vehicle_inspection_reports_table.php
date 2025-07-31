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
        Schema::table('vehicle_inspection_reports', function ($table) {

            $table->string('engine_cc')->nullable();
            $table->string('horsepower')->nullable();
            $table->string('noOfCylinders')->nullable();
            $table->string('transmission')->nullable();
            $table->string('specs')->nullable();
            $table->string('registerEmirates')->nullable();
            $table->string('body_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_inspection_reports', function ($table) {


            $table->dropColumn('engine_cc');
            $table->dropColumn('horsepower');
            $table->dropColumn('noOfCylinders');
            $table->dropColumn('transmission');
            $table->dropColumn('specs');
            $table->dropColumn('registerEmirates');
            $table->dropColumn('body_type');
        });
    }
};
