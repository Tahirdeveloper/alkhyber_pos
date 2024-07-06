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
        Schema::create('paid_dues', function (Blueprint $table) {
            $table->id();
            $table->integer('paid_amount')->default(0);
            $table->text('note')->nullable();
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paid_dues');
    }
};
