<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inspection_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_inspection_report_id')->nullable();
            $table->string('name')->nullable();    
            $table->string('value', 255)->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_fields');
    }
};
