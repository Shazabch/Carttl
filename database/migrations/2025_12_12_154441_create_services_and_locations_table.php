<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services_and_locations', function (Blueprint $table) {
            $table->id();
            $table->string('service_name')->nullable();           // Name of the service
            $table->decimal('service_amount')->nullable(); // Service cost/amount
            $table->string('location')->nullable();               // Location info
            $table->string('type')->nullable();                   // Type of service (e.g., online, offline)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services_and_locations');
    }
};
