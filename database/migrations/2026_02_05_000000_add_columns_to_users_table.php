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
            $table->string('warranty')->nullable();
            $table->decimal('asking_price', 13, 2)->nullable();
            $table->decimal('auction_price', 13, 2)->nullable();
            $table->text('notes')->nullable();
            $table->json('user_documents')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['warranty', 'asking_price', 'auction_price', 'notes', 'user_documents']);
        });
    }   
};
