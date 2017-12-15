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
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('slug');
            $table->integer('order')->default(999);
            $table->integer('stock')->default(0);
            $table->float('weight')->default(1);
            $table->string('name');
            $table->string('image');
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->float('discounted_price')->default(0);
            $table->float('price');
            $table->float('actual_price');
            $table->boolean('is_sale')->default(false);
            $table->boolean('is_featured')->default(false);

            $table->dateTime('published_at')->nullable();
            $table->timestamps();

            $table->foreign('category_id')
                  ->references('id')->on('categories')
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
        Schema::dropIfExists('products');
    }
}
