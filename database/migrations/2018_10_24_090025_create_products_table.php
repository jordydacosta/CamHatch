<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Product;
use App\Tax;
use App\InvoiceLine;

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
            $table->string('name_en');
            $table->string('name_nl');
            $table->decimal('price', 6, 2);
            $table->unsignedInteger('tax_id');
            $table->timestamps();
            $table->foreign('tax_id')
                ->references('id')->on('taxes');
        });

        $tax = Tax::where('ident', '=', 'hoog')->first();
        Product::Create(['name_en' => 'CamHatch', 'name_nl' => 'CamHatch', 'price' => 9.99, 'tax_id' => $tax->id]);

        Schema::table('invoice_lines', function (Blueprint $table) {
            $table->unsignedInteger('product_id')->after('tax')->default(1);
            $table->foreign('product_id')
                ->references('id')->on('products');
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
