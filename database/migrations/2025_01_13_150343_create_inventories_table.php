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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->integer('item_code');
            $table->string('barcode')->nullable();
            $table->string('name');
            $table->foreignId('brand_id')->nullable()
                ->constrained('brands')
                ->onDelete('set null');
            $table->foreignId('category_id')->nullable()
                ->constrained('categories')
                ->onDelete('set null');
            $table->text('description')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->string('colour')->nullable();
            $table->string('volume')->nullable(); 
            $table->decimal('unit_cost', 10, 2);
            $table->decimal('unit_price', 10, 2);
            $table->integer('stock_quantity');   
            $table->integer('discount_amount')->nullable();   
            $table->integer('discount_percentage')->nullable();   
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
