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
             $table->string('view_count')->nullable();
             $table->date('sold_at')->nullable();
             $table->string('top_speed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
              $table->dropColumn('view_count');
              $table->dropColumn('sold_at');
              $table->dropColumn('top_speed');
        });
    }
};
