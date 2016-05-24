<?php

use Illuminate\Database\Seeder;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('services')->delete();
      //injecte le tableau lignes
      for($i=1;$i<=10;$i++)
      {
        DB::table('services')->insert([
          'id' => $i,
          'name'=> 'Service '.$i
        ]);
      }
    }

}
