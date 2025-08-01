<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('vehicle_histories', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('vehicle_id'); 

        $table->string('event_type');        
        $table->date('event_date')->nullable();
        $table->string('location')->nullable();
        $table->integer('mileage')->nullable();
        $table->string('owner_status')->nullable();     
        $table->string('dealer_status')->nullable();     
        $table->string('title_status')->nullable();      
        $table->string('accident_status')->nullable();   
        $table->boolean('verified')->default(false);     

        $table->timestamps();

       
    });
}

public function down()
{
   

    Schema::dropIfExists('vehicle_histories');
}


};
