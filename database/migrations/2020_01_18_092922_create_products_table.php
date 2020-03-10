<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->integer('vendor_id');
            $table->integer('offer_id')->nullable();
            $table->string('name');
            $table->longText('specification')->nullable();
            $table->longText('description')->nullable();
            $table->integer('stock')->nullable();
            $table->longText('image')->nullable();
            $table->float('price')->nullable();
            $table->float('offer_price')->nullable();
            $table->string('size_capacity')->nullable();
            $table->string('model')->nullable();
            $table->integer('offer_limit')->nullable();
            $table->string('model')->nullable();
            $table->string('color')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('products');
    }
}
