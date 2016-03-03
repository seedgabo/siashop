<?php

use Illuminate\Database\Seeder;

class CategoriasTicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\CategoriasTickets::create([
        	'nombre' => 'Soporte', 
        	'descripción'  => 'Soporte',
        	'user_id' => array(1,2,3,4,5),
        	]); 
        \App\Models\CategoriasTickets::create([
        	'nombre' => 'Nomina', 
        	'descripción'  => 'Nomina',
        	'user_id' => array(1,2,3,4,5),
        	]); 
        \App\Models\CategoriasTickets::create([
        	'nombre' => 'Ventas', 
        	'descripción'  => 'Ventas',
        	'user_id' => array(1,2,3,4,5),
        	]); 
        \App\Models\CategoriasTickets::create([
        	'nombre' => 'General', 
        	'descripción'  => 'General',
        	'user_id' => array(1,2,3,4,5),
        	]); 
       	\App\Models\CategoriasTickets::create([
        	'nombre' => 'Planeación', 
        	'descripción'  => 'Planeación',
        	'user_id' => array(1,2,3,4,5),
        	]); 
    }
}
