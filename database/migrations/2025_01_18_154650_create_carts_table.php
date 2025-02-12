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
        Schema::create('carts', function (Blueprint $table) {
             $table->id();
             $table->string('cart_number')->unique();
             $table->unsignedBigInteger('customer_id')->nullable();  // Change to this instead of foreignId
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->enum('status', ['neworder', 'processing', 'paid', 'delivered', 'cancelled'])->default('neworder');
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};