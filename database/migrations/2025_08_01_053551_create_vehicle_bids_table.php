<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
   public function up()
{
    Schema::create('vehicle_bids', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('vehicle_id'); 
        $table->unsignedBigInteger('user_id');   
        $table->double('bid_amount');    
        $table->timestamp('bid_time')->useCurrent(); 
        $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); 
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('vehicle_bids');
}


};
