<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNetoToDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carritos', function (Blueprint $table) {
            $table->boolean('neto')->default(0);
            $table->string('observacion',50)->nullable();
        });
        Schema::table('cartera', function (Blueprint $table) {
            $table->boolean('neto')->default(0);
            $table->double('flete',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
