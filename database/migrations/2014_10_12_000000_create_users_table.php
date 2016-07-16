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
            $table->string('password', 60);
            $table->boolean('admin')->default('0');
            $table->boolean('clientes_propios')->default('0');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE [dbo].[users] ADD  [nombre] varchar(255) NOT NULL');
        DB::statement('ALTER TABLE [dbo].[users] ADD  [email] varchar(255) UNIQUE');
        DB::statement("ALTER TABLE [dbo].[users] ADD  [empresas_id] varchar(255) DEFAULT '[1]' ");
        DB::statement('ALTER TABLE [dbo].[users] ADD  [cod_vendedor] varchar(255)');
        DB::statement('ALTER TABLE [dbo].[users] ADD  [COD_CLI] varchar(255)  NULL');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
