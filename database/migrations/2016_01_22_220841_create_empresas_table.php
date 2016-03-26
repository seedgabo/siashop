<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string("direccion_base_de_datos",255);
            $table->string("direccion_tabla_clientes",255);
            $table->integer('num_ped')->nullable();
            $table->integer('cartera_global')->default(1);
            $table->integer('clientes_global')->default(1);
            $table->string("emails");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('empresas');
    }
    
}
