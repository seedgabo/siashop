<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function(Blueprint $table) {
            $table->increments('id');
			$table->string('titulo');
			$table->text('contenido');
            $table->string('user_id');
            $table->string('guardian_id');
			$table->enum('estado', ['abierto', 'completado', 'en curso', ' rechazado','atrasado','vencido']);
			$table->string('categoria_id');
			$table->string('archivo');
            $table->boolean("transferible")->default(true);
            $table->timestamp('vencimiento')->nullable();
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
        Schema::drop('tickets');
    }
}
