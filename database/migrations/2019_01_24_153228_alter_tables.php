<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->double('price_ex',10,5)->unasigned();
            $table->double('BTW',10,5)->unasigned();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->string('invoice_id')->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('reference')->unasigned();
            $table->date('delivery_date')->unasigned();
            $table->string('shipping_price')->unasigned();
            $table->unsignedInteger('country_id')->nullable();
            $table->double('price_ex',10,2)->unasigned();
            $table->double('price_btw',10,2)->unasigned();

            //foreign key
            $table->foreign('country_id')
                ->references('id')->on('countries');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alterTables');
    }
}
