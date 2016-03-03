<?php 
namespace App;

use App\Dbf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Tests\HttpCache\request;

class Funciones
{

    public static function  utf8_encode_deep(&$input) 
    {
        if (is_string($input)) {
            $input = utf8_encode($input);
        } else if (is_array($input)) {
            foreach ($input as &$value) {
                Funciones::utf8_encode_deep($value);
            }

            unset($value);
        } else if (is_object($input)) {
            $vars = array_keys(get_object_vars($input));

            foreach ($vars as $var) {
                Funciones::utf8_encode_deep($input->$var);
            }
        }
    }

    public static function  transdate($cadena, $diferencia = false)
	{
		$recibido = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Mon','Tue','Wed','Thu','Fri','Sat','Sun','January','February','March','April','May','June','July','August','September','October','November','December','second','seconds','minute','minutes','day','days','hour','hours','month','months','year','years','week','weeks','before','after',"of");
		$traducido = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Lun','Mar','Mie','Jue','Vie','Sab','Dom','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Segundo','Segundos','Minuto','Minutos','Dia','Dias','Hora','Horas','Mes','Meses','Año','Años','Semana','Semanas','Antes','Despues',"de");
		$texto = str_replace($recibido,$traducido,$cadena);
		if (ends_with($texto,"Antes"))
		{
			$texto = "Dentro de " .str_replace("Antes","",$texto); 
		}
		if (ends_with($texto,"Despues"))
		{
			$texto = "Hace " .str_replace("Despues","",$texto); 
		}

		if($diferencia == true)
		{
			$texto = str_replace(["Dentro de ", "Hace "],"",$texto); 
		}

		return $texto;
	}

    public static function  printable($array)
    {
     if (count($array) > 0)
     {
         $tabla =   "<table>
         <thead>
            <tr>
              <th>" . implode('</th><th>', array_keys(current($array))) . "</th></tr></thead> <tbody>";
              foreach ($array as $row): 
                array_map('htmlentities', $row);
            $tabla.="  <tr><td>" . implode('</td><td>', $row) ."</td> </tr>";
            endforeach; 
            $tabla.="</tbody></table>";
        }
        return $tabla;
    }


    public static function  getEmpresa()
    {
        $empresa = Empresas::find(Session::get('empresa'));
        return $empresa;
    }

    public static function  getCliente()
    {
       $cliente = (new Dbf(Funciones::getPathCli()))->where('COD_TER',Session::get('cliente'))->first();
       return $cliente;
    }

    public static function  borrarCarrito()
    {
        Carritos::where('user_id',Auth::user()->id)
        ->where('COD_CLI',Session::get('cliente'))
        ->delete();
    }

    public static function procesarCarrito($productos)
    {
        $empresa =  Funciones::getEmpresa();
        $num_ped = $empresa->num_ped;
        $codigos = [];
        $fila = [];
        $pedidos = new Dbf(Funciones::getPathPed());
        foreach ($productos as $producto) {
            $fila = [];
            $fila[] = str_pad($num_ped,"0");
            $fila[] = Date('Ymd');
            $fila[] = Funciones::getCliente()['COD_TER'];
            $fila[] = $producto->COD_REF;
            $fila[] = $producto->cantidad;
            $fila[] = $producto->VAL_REF;
            $fila[] = Auth::user()->cod_vendedor;
            var_dump($fila);
            $pos[] = $pedidos->insert($fila);
        }
        $empresa->num_ped++;
        $empresa->save();
        return $pos;
    }

    public static function sendMailProccessCarrito($productos, $emails,$user ,$empresa,$cliente)
    {
        Mail::send('emails.CarritoProcesado', ['user' => $user,'cliente' => $cliente ,'empresa' => $empresa, 'email' => $emails,'productos' => $productos], function ($m) use ($user, $empresa , $emails) 
        {
            $m->from('sistemaSiasoft@siasoftsas.com', $empresa->nombre);
            $m->to($emails)->subject('¡Tu compra ha sido procesada!');
        });
    }

    public static function sendMailUser($user)
    {
        $empresa = Funciones::getEmpresa();
        Mail::send('emails.NewUser', ['user' => $user], function ($m) use ($user ,$empresa) 
        {
            $m->from('sistemaSiasoft@siasoftsas.com', $empresa->nombre);
            $m->to($user->email);
            $m->subject('¡Usuario Creado con Exito!');
        });
    }

    public static function sendMailNewTicket($ticket, $user, $guardian)
    {
        Mail::send('emails.NewTicket', ['user' => $user,'guardian' => $guardian ,'ticket' => $ticket], function ($m) 
            use ($user, $guardian) 
        {
            $m->from('sistemaSiasoft@siasoftsas.com', "Sistema Siasoft");
            $m->to($guardian->email)->subject('¡Nuevo Ticket Asignado!');
        });
    }



    public static function getUrlProducto($producto)
    {
        if(File::exists(public_path().'/img/'. Funciones::getEmpresa()->id .'/productos/' . trim($producto['COD_REF']) .".jpg"))
            return $url = asset('img/'. Funciones::getEmpresa()->id .'/productos/' . trim($producto['COD_REF']) .".jpg");
        else
            return $url = asset("img/nodisponible.jpg");
    }

    public static function getPathRef()
    {
        $empresa =Empresas::find(Session::get('empresa'));
        return $empresa->direccion_base_de_datos . "/IN.SIA/REFEREN.DBF";
    }    
    public static function getPathPed()
    {
        $empresa =Empresas::find(Session::get('empresa'));
        return $empresa->direccion_base_de_datos . "/IN.SIA/PEDIDOS.DBF";
    }
    public static function getPathCli()
    {
        $empresa =Empresas::find(Session::get('empresa'));
        return $empresa->direccion_tabla_clientes . "/MAE_TER.DBF";
    }
}