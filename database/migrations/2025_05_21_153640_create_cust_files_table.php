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
        Schema::create('cust_files', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
             $table->decimal('total', 8, 2)->default(0);
             $table->decimal('paid', 8, 2)->default(0);
            $table->decimal('remain', 8, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cust_files');
    }
};
