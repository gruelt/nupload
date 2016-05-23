<?php

use Illuminate\Database\Seeder;

class FormulaireUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('formulaire_user')->delete();
      //injecte $i lignes
      for($i=1;$i<5;$i++)
      {
        DB::table('formulaire_user')->insert([
          'user_id'=> 1,
          'formulaire_id' => $i
        ]);
      }
    }

}
