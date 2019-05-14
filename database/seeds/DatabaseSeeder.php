<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if (App::environment() !== 'testing')
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        $this->call(UserTableSeeder::class);
        $this->command->info('Seeded the users!');


        if(\Config::get('app.debug')){

            $this->call(ReviewTableSeeder::class);
            $this->command->info('Seeded the reviews!');

            //Seed the countries
            $this->call(OrderTableSeeder::class);
            $this->command->info('Seeded the orders!');

            $this->call(CountryTableSeeder::class);
            $this->command->info('Seeded Country!');

            $this->call(VoucherTableSeeder::class);
            $this->command->info('Vouchers has been seeded');

            $this->call(ProductTableSeeder::class);
            $this->command->info('Seeded/ updated the products');
        }

        if (App::environment() !== 'testing')
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Model::reguard();
    }
}
