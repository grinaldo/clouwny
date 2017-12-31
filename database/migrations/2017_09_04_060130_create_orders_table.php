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
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('order_number')->unique()->nullable();
            $table->string('latest_status')->nullable();
            $table->string('delivery_company');
            $table->string('delivery_type');
            $table->integer('shipping_fee');
            $table->integer('total_fee');
            $table->string('confirmation_channel')->nullable();
            $table->string('confirmation_account')->nullable();
            $table->string('confirmation_transfer')->nullable();
            $table->dateTime('confirmation_transfer_date')->nullable();
            $table->float('confirmation_transfer_amount')->nullable();
            $table->string('confirmation_payer')->nullable();

            $table->boolean('is_dropship')->default(false);
            $table->string('shipper_name')->nullable();
            $table->string('shipper_phone')->nullable();
            $table->string('shipper_email')->nullable();
            $table->string('shipper_province')->nullable();
            $table->string('shipper_city')->nullable();
            $table->string('shipper_district')->nullable();
            $table->string('shipper_zipcode')->nullable();
            $table->string('shipper_address')->nullable();

            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->string('receiver_email')->nullable();
            $table->string('receiver_province');
            $table->string('receiver_city');
            $table->string('receiver_district');
            $table->string('receiver_zipcode')->nullable();
            $table->string('receiver_address');
            $table->string('payment_method');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
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
        Schema::table('orders', function(Blueprint $table){
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('orders');
    }
}
