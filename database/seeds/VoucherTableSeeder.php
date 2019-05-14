<?php

use Illuminate\Database\Seeder;
use App\Voucher as Voucher;

class VoucherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vouchers')->truncate();

        for ($i=0; $i < 5; $i++) {

            Voucher::create([
                'vouchercode' => (string) uniqid(),
                'amount' => rand(1, 7),
                'discount_percent' => rand(1, 50),
                'expires_at' => null,
                'minimum_order_quantity' => rand(1, 25),
            ]);
        }
    }
}
