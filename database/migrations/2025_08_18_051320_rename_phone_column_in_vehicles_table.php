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
        $table->renameColumn('resevre_status', 'reserve_status');
    });
}

public function down(): void
{
    Schema::table('vehicles', function (Blueprint $table) {
        $table->renameColumn('reserve_status', 'resevre_status');
    });
}
};
