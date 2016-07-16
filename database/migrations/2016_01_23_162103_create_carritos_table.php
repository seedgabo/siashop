<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarritosTable extends Migration
{
  public function up()
    {
        Schema::create('carritos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empresa_id');
            $table->integer('estado')->default(0); // 0 "En curso" , 1 "Completada" ,  2 "subida al sistema"
            $table->integer("cantidad");
            $table->integer('VAL_REF');
        });
        DB::statement("ALTER TABLE [dbo].[carritos] ADD  [user_id] char(5)  NULL  ");
        DB::statement("ALTER TABLE [dbo].[carritos] ADD  [COD_VEN] char(3)  NULL  ");
        DB::statement("ALTER TABLE [dbo].[carritos] ADD  [num_ped] char(10) NULL  ");
        DB::statement("ALTER TABLE [dbo].[carritos] ADD  [fecha]   char(15) NULL  ");
        DB::statement("ALTER TABLE [dbo].[carritos] ADD  [COD_CLI] char(15) NULL  ");
        DB::statement("ALTER TABLE [dbo].[carritos] ADD  [COD_REF] char(15) NULL  ");
        DB::statement("ALTER TABLE [dbo].[carritos] ADD  [NOM_REF] char(50) NULL  ");
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
