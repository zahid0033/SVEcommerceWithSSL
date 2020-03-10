<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id');
            $table->integer('shipping_id')->nullable();
            $table->integer('payment_id')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('product_ids')->nullable();
            $table->string('selling_price')->nullable();
            $table->string('quantity')->nullable();
            $table->string('offer_type')->nullable();
            $table->string('offer_percentage')->nullable();
            $table->string('free_product_ids')->nullable();
            $table->integer('subtotal')->nullable();
            $table->integer('total')->nullable();
            $table->string('status')->nullable();
            $table->string('reason')->nullable();
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
