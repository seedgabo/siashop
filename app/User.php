<?php

namespace App;

use App\Empresas;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email','empresas_id','cod_vendedor' ,'admin'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

      protected $casts = [
        'empresas_id' => 'array',
    ];


    public function Empresas()
    {
        return Empresas::wherein('id', $this->empresas_id)->get();
    }
}
