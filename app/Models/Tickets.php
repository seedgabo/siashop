<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Tickets",
 *      required={titulo, contenido, user_id, estado, categoria_id},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="titulo",
 *          description="titulo",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="contenido",
 *          description="contenido",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="estado",
 *          description="estado",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="categoria_id",
 *          description="categoria_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="archivo",
 *          description="archivo",
 *          type="string"
 *      )
 * )
 */
class Tickets extends Model
{
    use SoftDeletes;

    public $table = "tickets";
    
	protected $dates = ['deleted_at'];

    
    public $fillable = [
        "titulo",
		"contenido",
		"user_id",
		"estado",
		"categoria_id",
		"archivo"
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        "titulo" => "string",
		"contenido" => "string",
		"user_id" => "string",
		"estado" => "string",
		"categoria_id" => "string",
		"archivo" => "string"
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        "titulo" => "required|min:8|max:50",
		"contenido" => "required|min:8",
		"user_id" => "required",
		"estado" => "required",
		"categoria_id" => "required",
		"archivo" => "unique:tickets"
    ];


    public static function byCategorias($categorias)
    {
        $tickets = Tickets::all();
        $permitidas = [];
        foreach ($tickets as $ticket) 
        {
             if (in_array($ticket->categoria_id  ,$categorias->id))
                $permitidas[] =  $ticket;
         } 
        return $permitidas;
    }

    public function archivo()
    {
        return asset("archivos/tickets/". $this->archivo);
    }
}
