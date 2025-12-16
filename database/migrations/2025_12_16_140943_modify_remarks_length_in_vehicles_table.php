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
            $table->string('remarks', 2000)->nullable()->change(); // Change length to 500
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('remarks', 255)->nullable()->change(); // Revert back
        });
    }
};
