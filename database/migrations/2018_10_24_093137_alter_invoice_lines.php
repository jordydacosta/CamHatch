<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInvoiceLines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_lines', function (Blueprint $table) {
            $table->decimal('price', 6, 2)->change();
            $table->decimal('tax', 6, 2)->change();
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('price', 6, 2)->change();
            $table->decimal('tax', 6, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
