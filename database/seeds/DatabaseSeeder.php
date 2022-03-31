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
        $this->call(UserSeeder::class);
        $this->call(UmSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(StockSeeder::class);
    }
}
