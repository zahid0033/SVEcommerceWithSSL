<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('store_amount')->nullable();
            $table->string('bank_tran_id')->nullable();
            $table->date('tran_date')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_type')->nullable();
            $table->string('currency_amount')->nullable();
            $table->string('currency_rate')->nullable();
            $table->string('base_fair')->nullable();
            $table->string('card_type')->nullable();
            $table->string('card_no')->nullable();
            $table->string('card_issuer')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_issuer_country')->nullable();
            $table->string('card_issuer_country_code')->nullable();
            $table->string('error')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
