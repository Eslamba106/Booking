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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->nullable(); // varchar(3) DEFAULT NULL
            $table->string('name', 150)->nullable(); // varchar(150) DEFAULT NULL
            $table->integer('dial_code')->default(0); // int(11) NOT NULL DEFAULT 0
            $table->string('currency_name', 20)->nullable(); // varchar(20) DEFAULT NULL
            $table->string('currency_symbol', 20)->nullable(); // varchar(20) DEFAULT NULL
            $table->string('currency_code', 20)->nullable(); // varchar(20) DEFAULT NULL
            $table->tinyInteger('den_val')->default(0); // tinyint(4) NOT NULL DEFAULT 0
            $table->string('nationality', 150)->nullable(); // varchar(150) DEFAULT NULL 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
