<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('admin')->default(false);
            $table->integer('id_service')->unsigned();
            $table->timestamps();
            $table->foreign('id_service')
                  ->references('id')
                  ->on('services')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->rememberToken();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table){
          $table->dropForeign('user_id_service_foreign');
        });

        Schema::drop('users');
    }
}
