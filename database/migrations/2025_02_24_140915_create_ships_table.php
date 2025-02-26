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
        Schema::create('ships', function (Blueprint $table) {
            $table->id();
            $table->longText('note');
            $table->string('From');
            $table->string('To');
            $table->double('weight');
            $table->integer('quantity');
            $table->enum('status' , ['pending','in_transit','delivered','canceled'])->default('pending');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('clients');
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->foreign('trip_id')->references('id')->on('trips');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ships');
    }
};
