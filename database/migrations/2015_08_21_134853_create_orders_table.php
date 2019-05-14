<?php

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

            $table->string('orderId', 20);

            // Customer info
            $table->string('firstname', 255);
            $table->string('lastname', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->string('customer_ip', 255);
            $table->string('company', 255)->nullable();
            $table->string('address', 255);
            $table->string('zipcode', 255);
            $table->string('city', 255);
            $table->string('country', 255);

            // Shipping info
            $table->boolean('same_as_billing_address')->default(1);
            $table->string('shipping_firstname', 255)->nullable();
            $table->string('shipping_lastname', 255)->nullable();
            $table->string('shipping_company', 255)->nullable();
            $table->string('shipping_address', 255)->nullable();
            $table->string('shipping_zipcode', 255)->nullable();
            $table->string('shipping_city', 255)->nullable();
            $table->string('shipping_country', 255)->nullable();
            
            // Order info
            $table->string('quantity', 255);
            $table->decimal('price', 9, 2);
            // $table->decimal('tax', 9, 2);
            $table->string('comment', 300)->nullable();
            //$table->integer('payment_method');
            $table->integer('shipping_plan');

            $table->integer('orderstatus_id');
            //$table->string('paypal_payment_id', 255)->nullable();
            //vouch

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
        Schema::drop('orders');
    }
}
