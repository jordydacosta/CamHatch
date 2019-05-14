<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKortingscodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vouchercode');
            $table->integer('amount');
            $table->integer('discount_percent');
            $table->timestamp('expires_at');
            $table->string('minimum_order_quantity');
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('voucher_id')->nullable();

            //foreign key
            $table->foreign('voucher_id')
                ->references('id')->on('vouchers');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kortingscodes');
    }
}
