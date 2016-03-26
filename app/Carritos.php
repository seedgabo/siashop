<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carritos extends Model
{
    use SoftDeletes;
    protected $table = 'carritos';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'NOM_REF','user_id','empresa_id','transaccion','estado','COD_REF','cantidad','VAL_REF', 'nombre_cliente','COD_CLI'
    ];

    public static function CarritoActual()
    {
    	return Carritos::where('user_id',Auth::user()->id)
    	->where("empresa_id",Session::get('empresa'))
    	->where("COD_CLI",Session::get('cliente'))
    	->get();
    }
}
