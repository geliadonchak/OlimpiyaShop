<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Baskets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baskets', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('product_id')->references('id')->on('products');
            $table->integer('count')->default(1);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('count')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('count');
        });

        Schema::dropIfExists('baskets');
    }
}
