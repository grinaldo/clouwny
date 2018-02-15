<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('product_variant_id')->unsigned()->nullable();
            $table->string('size')->default('M');
            $table->integer('amount')->default(1);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::dropIfExists('carts');
    }
}
