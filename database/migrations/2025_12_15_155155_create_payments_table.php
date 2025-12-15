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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable(); // just store user_id, no foreign key
        $table->string('package_id')->nullable();          // purchased package id
        $table->string('pdf_link')->nullable();            // PDF link
        $table->string('price')->nullable();            // PDF link
        $table->string('status')->default('pending'); // optional: pending, completed, failed
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('payments');
}

};
