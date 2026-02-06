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
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->decimal('asking_price', 13, 2)->nullable();
            $table->decimal('auction_price', 13, 2)->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_inspection_reports', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'asking_price', 'auction_price', 'notes']);
        });
    }
};
