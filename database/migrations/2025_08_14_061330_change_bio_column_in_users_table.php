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
        Schema::table('users', function (Blueprint $table) {
            // Keep phone as double
            $table->double('phone')->nullable()->change();

            // Change bio to text
            $table->text('bio')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->double('phone')->nullable()->change();
            $table->double('bio')->nullable()->change();
        });
    }
};
