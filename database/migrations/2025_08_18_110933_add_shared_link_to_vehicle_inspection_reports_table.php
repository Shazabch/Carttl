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
            $table->text('shared_link')->nullable()->after('file_path');
            $table->timestamp('shared_link_expires_at')->nullable()->after('shared_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_inspection_reports', function (Blueprint $table) {
                $table->dropColumn(['shared_link', 'shared_link_expires_at']);
        });
    }
};
