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
            $table->string('owner_type')->nullable();
            $table->boolean('owner_is_dealer')->default(false);
            $table->string('car_registered_in')->nullable();
            $table->boolean('bank_loan')->default(false);
            $table->string('bank_loan_status')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->boolean('customer_has_trn_number')->default(false);
            $table->date('dob')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'owner_type',
                'owner_is_dealer',
                'car_registered_in',
                'bank_loan',
                'bank_loan_status',
                'gender',
                'nationality',
                'customer_has_trn_number',
                'dob'
            ]);
        });
    }
};
