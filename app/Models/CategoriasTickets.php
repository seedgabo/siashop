<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CategoriasTickets extends Model
{

    public $table = "categorias_tickets";

	protected $dates = ['deleted_at'];


    public $fillable = [
    "nombre",
		"descripción",
		"user_id"
    ];



    public static function byUser($user = null)
    {
        if($user == null)
        {
            $user = Auth::user();
        }
        $permitidas = [];
        $categorias = CategoriasTickets::all();
        foreach ($categorias as $categoria) {
             if (in_array($user->id  ,$categoria->user_id))
             $permitidas[] =  $categoria;
         }
        return collect($permitidas);
    }

    public function  Users()
    {
        return \App\User::wherein("id",$this->user_id)->get();
    }
    
    protected $casts = [
        "nombre" => "string",
		"descripción" => "string",
		"user_id" => "array"
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        "nombre" => "required|min:3|max:50",
		"descripción" => "min:3"
    ];

      public function Tickets()
    {
        return $this->hasMany('App\Models\Tickets',"categoria_id");
    }


}
