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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone'); // يفضل أن يكون `string` بدلاً من `integer`
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('clients');
    Schema::enableForeignKeyConstraints(); 
}

};
