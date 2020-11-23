<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Comments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id');
            $table->text('text');
            $table->foreignId('product_id')->references('id')->on('products');
            $table->foreignId('author')->references('id')->on('users');
            $table->enum('rating', [0, 1, 2, 3, 4, 5])->default(5);
            $table->dateTime('date')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
