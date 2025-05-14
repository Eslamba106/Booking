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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();

            $table->date('arrival_date');
            $table->time('arrival_time');
            $table->date('leave_date');
            $table->time('leave_time');
            $table->integer('days_count');
            $table->integer('total');
            $table->string('from_location');
            $table->string('to_location');
            $table->string('note');
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_id')->nullable()->constrained()->cascadeOnDelete();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
