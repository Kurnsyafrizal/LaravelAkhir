<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            UmSeeder::class,
            LocationSeeder::class,
            ItemSeeder::class,
            TransctionSeeder::class,
            StockSeeder::class,
        ]);
    }
}
