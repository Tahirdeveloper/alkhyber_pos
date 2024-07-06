<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 8, 4);
            $table->integer('quantity')->default(1);
            $table->integer('shorts')->nullable();
            $table->integer('kg_discount')->nullable();
            $table->integer('kgs')->nullable();
            $table->integer('kg_price')->nullable();
            $table->foreignId('product_id');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
