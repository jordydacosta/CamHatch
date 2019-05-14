<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMolliepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('molliepayments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payment_id');
            $table->boolean('is_paid');
            $table->string('status')->nullalble();
            $table->string('payment_code');
            $table->string('payment_method')->nullalble();
            $table->unsignedInteger('order_id');
            $table->timestamps();
            $table->foreign('order_id')
                ->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('molliepayments');
    }
}
