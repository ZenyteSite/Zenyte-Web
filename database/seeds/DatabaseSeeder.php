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
        $this->call(StoreSeeder::class);
        $this->call(VoteSeeder::class);
        $this->call(CreditPaymentSeeder::class);
//        $this->call(LogsSeeder::class);
    }
}
