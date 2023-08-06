<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
    
        foreach (range(1, 1000) as $index) {
            DB::table('stocks')->insert([
                'item_code' => $faker->unique()->bothify('??#####'),
                'item_name' => $faker->words(3, true),
                'quantity' => $faker->numberBetween(1, 100),
                'location' => $faker->city,
                'store_name' => $faker->randomElement(['Store A', 'Store B', 'Store C']),
                'in_stock_date' => $faker->date,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
