<?php

use Illuminate\Database\Seeder;

use App\Country as Country;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->truncate();

        $country_en = File::getRequire(base_path().'/resources/lang/en/countries.php');
        $country_nl = File::getRequire(base_path().'/resources/lang/nl/countries.php');

        foreach($country_en as $key => $value)
        {
            foreach($country_nl as $iso => $name)
            {
                if ($key == $iso){

                    $key = strtolower($key);
                    Country::create([
                        'country_en' => (string) $value,
                        'isocode' => $key,
                        'country_nl' => (string) $name,
                        'shipment_rate' => '7.26',
                    ]);
                }
            }
        }
    }
}
