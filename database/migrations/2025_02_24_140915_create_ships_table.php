<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ships', function (Blueprint $table) {
            $table->id();
            $table->string('note')->nullable();
            $table->string('from');  
            $table->string('to');    
            $table->double('weight');
            $table->double('price');
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2)->nullable();
            $table->decimal('total_weight', 10, 2)->nullable();
            $table->enum('status', ['pending', 'in_transit', 'delivered'])->default('pending');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ships');
    }
};
