<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installment_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->integer('customer_id')->nullable();
            $table->float('product_price')->nullable();
            $table->float('reduced_price')->nullable();
            $table->float('downPayment')->nullable();
            $table->float('due_amount')->nullable();
            $table->float('paid_amount')->nullable();
            $table->string('time_difference')->nullable();
            $table->float('installment_amount')->nullable();
            $table->integer('installment_number')->nullable();
            $table->string('installment_dates')->nullable();
            $table->string('payment_dates')->nullable();
            $table->string('installment_status')->nullable();
            $table->string('installment_note')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('installment_orders');
    }
}
