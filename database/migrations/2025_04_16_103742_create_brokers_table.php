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
        Schema::create('brokers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('email', 150)->unique();
            $table->string('phone', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->enum('status' ,  ['active' , 'disactive' ])->default('active');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brokers');
    }
};
