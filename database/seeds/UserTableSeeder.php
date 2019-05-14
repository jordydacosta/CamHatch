<?php

use Illuminate\Database\Seeder;
use App\User as User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
		DB::table('users')->truncate();

        if(\Config::get('app.debug')){
        	User::create([
                'name' => 'Willem',
                'email' => 'willem@camhatch.com',
                'password' => Hash::make('camhatch')
    		]);
        } else {
            User::create([
                'name' => 'Willem',
                'email' => 'willem@camhatch.com',
                'password' => Hash::make('pwd4c4mh4tch@2015')
            ]);
        }
    }
}
