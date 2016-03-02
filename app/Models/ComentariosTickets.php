<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="ComentariosTickets",
 *      required={texto, user_id},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="texto",
 *          description="texto",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class ComentariosTickets extends Model
{
    use SoftDeletes;

    public $table = "comentarios_tickets";
    
	protected $dates = ['deleted_at'];

    
    public $fillable = [
        "texto",
		"user_id",
        "ticket_id"
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        "texto" => "string",
		"user_id" => "integer",
        "ticket_id" => "integer"
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        "texto" => "required|min:8",
		"user_id" => "required",
        "ticket_id" => "required"
    ];
}
