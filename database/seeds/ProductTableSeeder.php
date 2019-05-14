<?php

use Illuminate\Database\Seeder;

use App\Product;
use App\Tax;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tax = Tax::where('ident', '=', 'hoog')->first();
        $products = [
            ['name_en' => "CamHatch",
            'name_nl' => "CamHatch",
            'price' => 9.99,
            'tax_id' => $tax->id,
            'price_ex' => 8.26,
            'BTW' => 1.73]
        ];

        foreach ($products AS $p) {
            $product = Product::where('name_en', '=', $p['name_en'])->first();
            if (!empty($product) === 0)
                $product = new Product;

            $product->name_en = $p['name_en'];
            $product->name_nl = $p['name_nl'];
            $product->price = $p['price'];
            $product->tax_id = $p['tax_id'];
            $product->price_ex = $p['price_ex'];
            $product->BTW = $p['BTW'];

            $product->save();
        }
    }
}
