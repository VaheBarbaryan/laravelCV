<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Input;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
    }
}
