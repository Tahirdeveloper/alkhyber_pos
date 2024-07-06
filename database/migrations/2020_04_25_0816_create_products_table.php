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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('supplier_id')->default(0);
            $table->string('category')->nullable();            
            $table->string('kg')->nullable();
            $table->integer('quantity')->default('1')->nullable();
            $table->integer('stock')->nullable();
            $table->integer('short')->default('0')->nullable();
            $table->integer('netWeight')->default('1')->nullable();
            $table->integer('kgDiscount')->default('0')->nullable();
            $table->boolean('status')->default(true);
            $table->string('barcode');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price',12, 2)->default(00);
            $table->string('tax')->nullable();            
            $table->string('purchase_price')->default(00); 
            $table->decimal('profit',8,2)->nullable()->default(0);             
            $table->string('sale_price')->nullable()->default(0);  
            $table->string('grossTotal')->default(0);  
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');      
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
