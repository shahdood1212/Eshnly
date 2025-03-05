<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    
        public function up(): void
        {
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->double('price');
                $table->enum('status', ['pending', 'accepted', 'rejected', 'completed'])->default('pending');
                $table->foreignId('trip_id')->constrained('trips')->onDelete('cascade');
                $table->foreignId('ship_id')->constrained('ships')->onDelete('cascade');
                $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
                $table->timestamps();
            });
        
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
