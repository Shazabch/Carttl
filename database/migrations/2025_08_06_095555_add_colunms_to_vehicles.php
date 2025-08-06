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
        Schema::table('vehicles', function (Blueprint $table) {
                $table->double('starting_bid_amount')->nullable();
                $table->double('zero_to_sixty')->nullable();
                $table->double('quater_mile')->nullable();
                $table->boolean('is_hot')->nullable();
                $table->boolean('inspected_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
             $table->dropColumn('starting_bid_amount');
              $table->dropColumn('zero_to_sixty');
              $table->dropColumn('quater_mile');
              $table->dropColumn('is_hot');
              $table->dropColumn('inspected_by');
        });
    }
};
