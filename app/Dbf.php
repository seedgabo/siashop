<?php 
namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Input;

class Dbf 
{
	public $path;
	public $where = array('deleted' => '0');
	public $data = array();
	public $paginator = "";


	// Constructor debe tener el path a donde esta ubicada la base de datos
	public function __construct ($path, $where = null)
	{	
		$this->path = $path;
		if (isset($where))
		{
		 	$this->where= $where;
		}
	}

	//Obtiene todos los registros que coincidan con el array where
	public function get()
	{
		$db = dbase_open($this->path, 0);

		if ($db) {
			$número_registros = dbase_numrecords($db);
			for ($i = 1; $i <= $número_registros; $i++) {
				$fila = dbase_get_record_with_names($db, $i);
				if ($this->validar($fila))
					$data[] = $fila;
			}
		}
		dbase_close($db);
		Funciones::utf8_encode_deep($data);
		return  new Collection($data);
	}


	//Extrae la fila  en la posicion  de la base de datos
	public function one($pos)
	{
		$db = dbase_open($this->path, 0);
		if ($db) {
			$número_registros = dbase_numrecords($db);
			if ($pos <= $número_registros)
				$fila = dbase_get_record_with_names($db, $pos);
		}
		dbase_close($db);
		Funciones::utf8_encode_deep($fila);
		return  $fila;
	}

	// Extrae la primera fila que cumpla las condiciones asignadas en el array Where
	public function first()
	{
		$db = dbase_open($this->path, 0);

		if ($db) {
			$número_registros = dbase_numrecords($db);
			for ($i = 1; $i <= $número_registros; $i++) {
				$fila = dbase_get_record_with_names($db, $i);
				if ($this->validar($fila))
				{
					dbase_close($db);
					Funciones::utf8_encode_deep($fila);
					return $fila;
				}
			}
		}
	}


    // Funcion para insertar en la base de datos devuelve la pos del registro insertado
	public function insert($fila)
	{
		if (isset($fila['deleted']))
			unset($fila['deleted']);
		$fila = array_values($fila);	
		$db = dbase_open($this->path, 2);
		if ($db) {
		  	dbase_add_record($db, $fila); 
		  	$num = dbase_numrecords($db);
		  	dbase_close($db);
		    return $num;
		}
	}


	// Funcion que permite traer de manera paginada los resultados de la tabla utilizando la variable get "P"
	public function paginate($take)
	{
		$data = $this->get();
		$pagina = Input::get('p', 0);
		return  new Collection(array_slice($data->toArray(), $take*$pagina ,$take, true));
	}





	// Agrega un valor al array where para buscar
	public function where ($key,$value)
	{
		$this->where = array_add($this->where , $key, $value);
		return $this;
	}


	//Recorre el vector where para ver si la fila cumple las condiciones
	private function validar($fila)
	{
		foreach ($this->where as $clave => $valor) {
			if (!(stripos((string) $fila[$clave], (string) $valor) !== false)) {
				return false;
			}
		}
		return true;
	}

	public function links()
	{
		$pagina = Input::get('p', 0);
		$html = " 
		<ul class='pagination'>
			<li ";

			if ((int)$pagina <= 0) {  $html.= " class='disabled' "; }		       
		
		 $html.= " > <a href='" ; 
		 			if ((int)$pagina > 0) {  $html.=  url()->current() . "?p=" . ($pagina -1) .  "' aria-label='Anterior'>";}
		 			else {$html.= "#!'"; }

		 $html .="<span aria-hidden='true'>Anterior</span>
		      </a>
		    </li>

		    <li><a href='#!'>". ($pagina + 1) ."</a></li>
			<li>
		      <a href='" . url()->current(). "?p=" . ($pagina + 1)  .  "' aria-label='Siguiente'>
		        <span aria-hidden='true'>Siguiente</span>
		      </a>
		    </li>
		 </ul>";

		  return $html;
	}	
}
