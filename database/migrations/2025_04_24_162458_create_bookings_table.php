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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->date('arrival_date');
            $table->date('check_out_date')->nullable();
            $table->integer('days_count')->default(1);
            $table->string('booking_no');
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->integer('canceled_period')->default(5);
            $table->decimal('price')->default(0);
            $table->decimal('buy_price')->default(0); 
            $table->decimal('earned')->default(0);  
            $table->decimal('broker_amount')->nullable();  
            $table->string('currency')->default('USD');
            $table->string('commission_type')->nullable();
            $table->string('commission_percentage')->nullable();
            $table->string('commission_night')->nullable();
            $table->string('commission')->nullable();
            $table->string('commission_amount')->nullable();
            $table->string('sub_total')->nullable();
            $table->integer('broker_id')->nullable();
            $table->string('total')->nullable();
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
