<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    protected $table = 'empresas';


       protected $fillable =
       [
        'nombre', 'direccion_base_de_datos','emails','direccion_tabla_clientes','num_ped', 'cartera_global', 'precio_global','clientes_global'
        ];


      protected $casts =
      [
        'emails' => 'array',
        'cartera_global' => 'boolean',
        'clientes_global' => 'boolean',
        'precio_global' => 'boolean'
      ];

}
