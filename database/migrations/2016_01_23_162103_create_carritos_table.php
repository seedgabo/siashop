<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarritosTable extends Migration
{
  public function up()
    {
        Schema::create('carritos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('empresa_id');
            // $table->integer('transaccion'); 
            $table->integer('estado')->default(0);    // 0 "En curso" , 1 "Completada" ,  2 "subida al sistema"
            $table->integer("num_ped")->nullable();
            $table->integer("cantidad");
            $table->string("nombre_cliente")->nullable();
            $table->double('VAL_REF', 15, 3);
            $table->string("COD_REF");
            $table->string("NOM_REF");
            $table->string('COD_CLI');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('carritos');
    }
}
