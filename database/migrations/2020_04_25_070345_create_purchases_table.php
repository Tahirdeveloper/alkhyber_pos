<?php

use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->date('purchaseDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('invoice_number')->default('null');
            $table->string('discount')->default('00');
            $table->string('allTotal');            
            $table->string('paidAmount');
            $table->text('purchase_note')->nullable();
            $table->integer('dues')->default(00);
            $table->string('payment_method')->default('Cash');
            $table->string('acc_no')->nullable();
            $table->text('payment_note')->nullable();
            $table->bigInteger('product_id')->default(0);
            $table->foreignId('supplier_id')->constrained('customers')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
