<?php

use Illuminate\Database\Seeder;
use App\Review as Review;

class ReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
		DB::table('reviews')->truncate();
        	
    	Review::create([
            'name' => 'Willem',
            'description' => 'An excellent solution, easy to place and use, and you hardly notice it!',
            'description_en'=> 'An excellent solution, easy to place and use, and you hardly notice it!',
            'rating' => 4,
            'visible' => 1
		]);

        Review::create([
            'name' => 'Smaïl Hammour',
            'description' => 'Excellent!!',
            'description_en'=>'Excellent!!',
            'rating' => 4,
            'visible' => 1
        ]);

        Review::create([
            'name' => 'Thomas Dingo',
            'description' => 'Certainly one of the best in it’s class.',
            'description_en' => 'Certainly one of the best in it’s class.',
            'rating' => 3,
            'visible' => 1
        ]);

        Review::create([
            'name' => 'Wesley Lorrez',
            'description' => 'Very nice, and good value for it’s price!',
            'description_en' => 'Very nice, and good value for it’s price!',
            'rating' => 4,
            'visible' => 1
        ]);
    }
}
