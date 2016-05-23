<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(FormulaireTableSeeder::class);
         $this->call(UserTableSeeder::class);
         $this->call(FormulaireUserTableSeeder::class);
    }
}
