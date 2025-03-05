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
            $table->foreignId('created_by')->constrained('clients')->onDelete('cascade'); // تعديل هنا
            $table->foreignId('trip_id')->nullable()->constrained('trips')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('ships', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['trip_id']);
        });

        Schema::dropIfExists('ships');
    }
};
