<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
            $table->foreignId('order_id')->references('id')->on('orders');
            $table->foreignId('product_id')->references('id')->on('products');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_paid')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('is_paid');
        });

        Schema::dropIfExists('order_items');
    }
}
