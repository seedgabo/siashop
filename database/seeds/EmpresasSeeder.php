<?php

use Illuminate\Database\Seeder;

class EmpresasSeeder extends Seeder
{

    public function run()
    {
        App\Empresas::create(['nombre' => 'Empresa 1','direccion_base_de_datos' => 'C:\xampp\htdocs\siashop\database', 'direccion_tabla_clientes' => 'C:\xampp\htdocs\siashop\database\CO.SIA' ,'emails' => array('seedgabo@gmail.com','oscar.rojas@siasoftsas.com')]);
        App\Empresas::create(['nombre' => 'Empresa 2','direccion_base_de_datos' => 'C:\xampp\htdocs\siashop\database', 'direccion_tabla_clientes' => 'C:\xampp\htdocs\siashop\database\CO.SIA' ,'emails' => array('seedgabo@gmail.com','oscar.rojas@siasoftsas.com')]);
        App\Empresas::create(['nombre' => 'Empresa 3','direccion_base_de_datos' => 'C:\xampp\htdocs\siashop\database', 'direccion_tabla_clientes' => 'C:\xampp\htdocs\siashop\database\CO.SIA' ,'emails' => array('seedgabo@gmail.com','oscar.rojas@siasoftsas.com')]);
        App\Empresas::create(['nombre' => 'Empresa 4','direccion_base_de_datos' => 'C:\xampp\htdocs\siashop\database', 'direccion_tabla_clientes' => 'C:\xampp\htdocs\siashop\database\CO.SIA' ,'emails' => array('seedgabo@gmail.com','oscar.rojas@siasoftsas.com')]);
        App\Empresas::create(['nombre' => 'Empresa 5','direccion_base_de_datos' => 'C:\xampp\htdocs\siashop\database', 'direccion_tabla_clientes' => 'C:\xampp\htdocs\siashop\database\CO.SIA' ,'emails' => array('seedgabo@gmail.com','oscar.rojas@siasoftsas.com')]);
    }
}
