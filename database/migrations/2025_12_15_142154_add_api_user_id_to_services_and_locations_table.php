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
        Schema::table('services_and_locations', function (Blueprint $table) {
            $table->string('service_type')->nullable();
            $table->string('paid_check')->nullable();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services_and_locations', function (Blueprint $table) {
            $table->dropColumn('service_type');
            $table->dropColumn('paid_check');
        });
    }
};
