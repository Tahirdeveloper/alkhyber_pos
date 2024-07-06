<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 8, 2);
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('dues', 8, 2)->nullable();
            $table->string('paymentMethod');
            $table->string('tid')->nullable();
            $table->date('date')->default()->default(DB::raw('CURRENT_DATE'));
            $table->text('additionalNotes')->nullable();
            $table->integer('customer_id')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
