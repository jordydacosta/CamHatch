<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Tax;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('ident');
            $table->integer('tax_rate');
            $table->timestamps();
        });
        
        Tax::Create(['ident' => 'hoog', 'name' => 'Hoog BTW tarief Nederland', 'tax_rate' => 21]);
        Tax::Create(['ident' => 'laag', 'name' => 'Laag BTW tarief Nederland', 'tax_rate' => 6]);
        Tax::Create(['ident' => 'geen', 'name' => 'Geen BTW Nederland', 'tax_rate' => 0]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxes');
    }
}
