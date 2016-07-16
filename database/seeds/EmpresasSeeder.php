<?php

use Illuminate\Database\Seeder;

class EmpresasSeeder extends Seeder
{

    public function run()
    {
        App\Empresas::create(['nombre' => 'Empresa 1','emails' => array('seedgabo@gmail.com','oscar.rojas@siasoftsas.com')]);
        App\Empresas::create(['nombre' => 'Empresa 2','emails' => array('seedgabo@gmail.com','oscar.rojas@siasoftsas.com')]);
        App\Empresas::create(['nombre' => 'Empresa 3','emails' => array('seedgabo@gmail.com','oscar.rojas@siasoftsas.com')]);
        App\Empresas::create(['nombre' => 'Empresa 4','emails' => array('seedgabo@gmail.com','oscar.rojas@siasoftsas.com')]);
        App\Empresas::create(['nombre' => 'Empresa 5','emails' => array('seedgabo@gmail.com','oscar.rojas@siasoftsas.com')]);
    }
}
