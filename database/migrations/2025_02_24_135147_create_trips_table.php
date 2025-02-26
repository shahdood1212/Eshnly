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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('From');
            $table->string('To');
            $table->string('departure_date');
            $table->string('arrival_date');
            $table->double('free_weight');
            $table->enum('status' , ['pending','canceled','completed'])->default('pending');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('clients');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_trips');
    }
};
