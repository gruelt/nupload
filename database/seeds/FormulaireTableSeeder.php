<?php

use Illuminate\Database\Seeder;

class FormulaireTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('formulaires')->delete();
      //injecte $i lignes
      for($i=1;$i<=10;$i++)
      {
        DB::table('formulaires')->insert([
          'id' => $i,
          'name'=> 'Formulaire '.$i
        ]);
      }
    }

}
