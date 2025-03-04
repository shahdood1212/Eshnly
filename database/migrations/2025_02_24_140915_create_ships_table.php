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
            $table->string('note')->nullable();
            $table->string('From');
            $table->string('To');
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
        
        // Schema::create('ships', function (Blueprint $table) {
        //     $table->string('from');
        //     $table->string('to');
        //     $table->decimal('weight', 8, 2);
        //     $table->decimal('price', 10, 2);
        //     $table->integer('quantity');
        //     $table->decimal('total_price', 10, 2)->default(0);
        //     $table->decimal('total_weight', 10, 2)->default(0);
        //     $table->enum('status', ['pending', 'in_transit', 'delivered', 'canceled'])->default('pending');
        //     $table->text('note')->nullable();
        //     $table->string('image')->nullable();
        //     $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
        //     $table->foreignId('trip_id')->constrained('trips')->onDelete('cascade');
        //     $table->timestamps();
                
        // });
    }

    
    public function down(): void
    {
        Schema::table('ships', function (Blueprint $table) {
            $table->dropColumn(['total_price', 'total_weight']);
        });
    }
};
