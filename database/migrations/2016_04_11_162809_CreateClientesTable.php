<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('COD_TER');
            $table->string('NOM_TER');
            $table->string('DIR1')->nullable();
            $table->string('TEL1')->nullable();
            $table->string('EMAIL')->nullable();
            $table->integer('TIP_PRV')->default(1);
            $table->string('NIT')->nullable();
            $table->string("COD_VEN")->nullable();
            $table->integer('empresa_id')->nullable();
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
        Schema::drop('clientes');
    }
}
