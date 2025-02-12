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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->unsignedBigInteger('customer_id')->nullable();  // Change to this instead of foreignId
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('invoice_number')->unique();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);            
            $table->decimal('total', 10, 2);
            $table->decimal('total_cost', 10, 2);
            $table->enum('payment_status', ['pending', 'paid','voided', 'failed'])->default('pending');
            $table->enum('payment_method', ['cash', 'card', 'bank_transfer'])->nullable();
             $table->timestamp('voided_at')->nullable();
            $table->string('sales_type'); 
            $table->string('cart_number');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};