<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder {    
 /**      * Run the database seeds. * * @return void      */    
  public function run()    
  { 
  	App\User::create(['nombre' => 'Gabriel Bejarano', 'email' => 'SeeDGabo@gmail.com','password' =>	Hash::make('gab23gab'),'empresas_id'  => array(1,2,3), 'admin' => 1 , 'cod_vendedor' => '0']); 
  	App\User::create(['nombre' => 'Usuario Siasoft', 'email' => 'soporte@siasoftsas.com','password' =>	Hash::make('siasoft'),'empresas_id'  => array(1,2,3,4,5), 'admin' => 1, 'cod_vendedor' => '1' ]); 
  }
}
