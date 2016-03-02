<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @SWG\Definition(
 *      definition="CategoriasTickets",
 *      required={nombre, descripción, user_id},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="nombre",
 *          description="nombre",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="descripción",
 *          description="descripción",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="string"
 *      )
 * )
 */
class CategoriasTickets extends Model
{
    use SoftDeletes;

    public $table = "categorias_tickets";
    
	protected $dates = ['deleted_at'];

    
    public $fillable = [
        "nombre",
		"descripción",
		"user_id"
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */

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
        "nombre" => "required|min:8|max:50",
		"descripción" => "required|min:8",
		"user_id" => "required"
    ];
}
