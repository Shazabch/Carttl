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
            $table->boolean('pre_owned')->nullable();
            $table->enum('status', [
                'draft',
                'published',
                'sold',
                'pending',
                'archived',
                'upcoming'
            ])->default('draft')->change();
            $table->enum('condition', [
                'new',
                'used',
                'certified by gx',
            ])->default('new')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('pre_owned');
            $table->enum('status', [
                'draft',
                'published',
                'sold',
                'pending'
            ])->default('draft')->change();
            $table->enum('condition', [
                'new',
                'used',
                'certified',
            ])->default('new')->change();
        });
    }
};
