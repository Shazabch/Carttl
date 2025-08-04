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
        Schema::table('vehicle_bids', function (Blueprint $table) {
            $table->double('current_bid')->nullable();
            $table->double('max_bid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_bids', function (Blueprint $table) {
             $table->dropColumn('current_bid');
            $table->dropColumn('max_bid');
        });
    }
};
