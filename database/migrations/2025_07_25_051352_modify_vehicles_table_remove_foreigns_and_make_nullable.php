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
            $table->renameColumn('model_id', 'vehicle_model_id');
        });
    }

    /**
     * Reverse the migrations.
     * This 'down' method will re-add the constraints and make columns not-nullable again.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->renameColumn('vehicle_model_id', 'model_id');
        });
    }
};
