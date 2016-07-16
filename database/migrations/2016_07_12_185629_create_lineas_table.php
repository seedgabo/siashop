<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('mae_tip', function (Blueprint $table) {
            $table->increments('id');
            $table->char('cod_tip',3);
            $table->char('nom_tip',50);
        });
       Schema::create('mae_gru', function (Blueprint $table) {
            $table->increments('id');
            $table->char('cod_gru',4);
            $table->char('nom_gru',50);
            $table->char('cod_tip',3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mae_tip');
        Schema::drop('mae_gru');
    }
}
