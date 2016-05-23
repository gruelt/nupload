<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormulaireUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('formulaire_user',function (Blueprint $table)
        {
          $table->increments('id');
          $table->integer('user_id')->unsigned();
          $table->integer('formulaire_id')->unsigned();
          $table->timestamps();
          $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
          $table->foreign('formulaire_id')
                ->references('id')
                ->on('formulaires')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

      Schema::table('formulaire_user', function(Blueprint $table) {
          $table->dropForeign('formulaire_user_user_id_foreign');
          $table->dropForeign('formulaire_user_formulaire_id_foreign');
        });


        //Schema::drop('formulaire_user');
    }
}
