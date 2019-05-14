<?php

use Illuminate\Database\Seeder;

use App\Order as Order;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
		DB::table('orders')->truncate();
      
        for ($i=0; $i < 20; $i++) { 

            $quantity = rand(1, 20);
            $price = $quantity * 9.99;

            Order::create([
                'firstname'     => 'Smaïl',
                'lastname'      => 'Hammour',
                'email'         => 'smail@pegus-apps.com',
                'phone'         => '+32475219234',
                'customer_ip'   => '127.0.0.1',
                'company'       => 'Pegus',
                'address'       => 'Boudewijnlaan 4',
                'zipcode'       => '8540',
                'city'          => 'Deerlijk',
                'country'       => 'be',
                'orderstatus_id' => rand(1, 7),
                'quantity'      => $quantity,
                'price'         => $price,
                'comment'       => 'Test comment',
                'shipping_plan'  => 1,
                'created_at'     => date('Y-m-d', strtotime( '+'.mt_rand(0,30).' days'))
            ]);
        }    	
    }
}
