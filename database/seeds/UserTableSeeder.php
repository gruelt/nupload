<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->delete();
      //injecte $i lignes

        DB::table('users')->insert([
          'id'=> 1,
          'name' => 'gruel',
          'email' => 'gruel@emse.fr',
          'password' => bcrypt('utzshu'),
          'admin' => 1,
          'id_service' => 1
        ]);

        DB::table('users')->insert([
          'id'=> 2,
          'name' => 'gruelt',
          'email' => 'gruelt@gmail.com',
          'password' => bcrypt('utzshu'),
          'admin' => 0,
          'id_service' => 2
        ]);




      }


}
