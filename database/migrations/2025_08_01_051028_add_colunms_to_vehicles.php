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
            $table->boolean('is_auction')->nullable();
             $table->double('current_bid')->nullable();
             $table->string('engine_type')->nullable();
             $table->date('auction_end_date')->nullable();
             $table->string('auction_location')->nullable();
             $table->string('shipping_information')->nullable();
             $table->string('resevre_status')->nullable();
             $table->string('auction_id')->nullable();
             $table->string('live_auction')->nullable();
             $table->string('no_of_cylinder')->nullable();
             $table->string('register_emirates')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
              $table->dropColumn('is_auction');
              $table->dropColumn('current_bid');
              $table->dropColumn('engine_type');
              $table->dropColumn('auction_end_date');
              $table->dropColumn('auction_location');
              $table->dropColumn('shipping_information');
              $table->dropColumn('resevre_status');
              $table->dropColumn('auction_id');
              $table->dropColumn('live_auction');
              $table->dropColumn('no_of_cylinder');
              $table->dropColumn('register_emirates');
        });
    }
};
