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
             $table->text('comment_section1')->nullable()->change();
             $table->text('comment_section2')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_inspection_reports', function (Blueprint $table) {
             $table->string('comment_section1', 'comment_section2')->nullable()->change();
        });
    }
};
