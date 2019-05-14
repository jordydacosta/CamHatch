<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMollieStatusCheckersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mollie_status_checkers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->unsignedInteger('payment_id');
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('molliepayments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mollie_status_checkers');
    }
}
