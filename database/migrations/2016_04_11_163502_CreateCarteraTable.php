<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarteraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartera', function (Blueprint $table) {
            $table->increments('id');
            $table->string('COD_TRN');
            $table->string('NUM_TRN');
            $table->string('COD_TER');
            $table->string('NOM_TER');
            $table->string('FEC_DOC', 10)->nullable();
            $table->string('FEC_VEN', 10)->nullable();
            $table->double('VALOR');
            $table->double('SIN_VEN');
            $table->double('A130');
            $table->double('A3160');
            $table->double('A6190');
            $table->double('A91120');
            $table->double('MAS120');
            $table->double('SALDO');
            $table->integer('dias');
            $table->string('COD_VEN');
            $table->integer('empresa_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cartera');
    }
}
