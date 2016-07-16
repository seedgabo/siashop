<?php

namespace App\Http\Controllers;

use App\Carritos;
use App\Dbf;
use App\Funciones;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Tickets;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Laracasts\Flash\Flash;

class AjaxController extends Controller
{
    public function setEmpresa(Request $request, $empresa)
    {
        if (in_array($empresa, Auth::user()->empresas_id))
        {
            $request->session()->put('empresa', $empresa);
            $request->session()->forget('cliente');
            if ($request->ajax())
                return "true";
            else
            {
                Flash::success('Empresa Seleccionada');
                $request->session()->flash('success', "Empresa Seleccionada");
                return redirect()->intended('menu');
            }
        }
        else
        {
            return  (new Response("No Autorizado", 401));
        }
    }

    public function setCliente(Request $request, $cliente)
    {
        if( Auth::user()->COD_CLI != "")
        {
            $request->session()->put('cliente', Auth::user()->COD_CLI);
        }
        else
        {
            $request->session()->put('cliente', $cliente);
        }
        if ($request->ajax())
        {
            return "true";
        }
        else
        {
            Flash::success('Cliente Seleccionado');
             return redirect()->intended('catalogo');
        }
    }

    public function addCarrito(Request $request)
    {
        $busqueda  = $request->only('COD_REF', 'COD_VEN', 'COD_CLI', 'empresa_id');
        $busqueda['estado'] = 0;
        $carrito = Carritos::firstOrNew($busqueda);
        $carrito->fill($request->all());
        $carrito->VAL_REF = floatval($request->get('VAL_REF'));
        $carrito->num_ped = Funciones::getEmpresa()->num_ped;
        $fecha = new Carbon();
        $carrito->fecha= $fecha->format("m/d/Y");
        $carrito->save();
        if ($request->ajax())
            return "true";
        else
        {
            Flash::success("Producto " . $request->get('NOM_REF') . " agregado al Carrito <a href='". url('carrito') ."'> IR AL CARRITO </a>");
            return redirect('/catalogo');
        }
    }

    public function deleteCarrito($id,Request $request)
    {
        $producto = Carritos::destroy($id);
        if ($request->ajax())
            return "true";
        else
            FLash::success("Producto  eliminado del Carrito");
            return  redirect('/carrito');
    }

    public function clearCarrito(Request $request)
    {
       Funciones::borrarCarrito();

        if ($request->ajax())
            return "true";
        else
             Flash::success("Productos  eliminados del Carrito");
            return  redirect('/carrito');
    }

    public function procesarCarrito(Request $request)
    {
        $empresa =  Funciones::getEmpresa();
        $cliente = Funciones::getCliente();
        $num_ped = $empresa->num_ped;
        $fecha = new \Carbon\Carbon();
        $fecha = $fecha->format('d/m/Y');
        $productos = Carritos::where('user_id',Auth::user()->id)
        ->where('COD_CLI',$request->session()->get('cliente'))
        ->where("estado", "0")->get();

        Carritos::where('user_id',Auth::user()->id)
        ->where('COD_CLI',$request->session()->get('cliente'))
        ->where("estado", "0")
        ->update(["estado" => "1", "num_ped" => $num_ped, "fecha" => $fecha]);

        $empresa->num_ped++;
        $empresa->save();
        Funciones::sendMailProccessCarrito($productos, $empresa->emails, Auth::user() ,$empresa,$cliente);
        if ($request->ajax())
            return "true";
        else
             Flash::success("Compra procesada");
            return  redirect('/carrito');
    }

    public function addCliente (Request $request)
    {
        $cliente = (new Dbf(Funciones::getPathCli()))->one(1);
        $keys =array_keys($cliente);
        foreach ($keys as $key)
        {
            $array[$key] = $request->input($key," ");
        }
        $pos = (new Dbf(Funciones::getPathCli()))->insert($array);
        Flash::success("Cliente Agregado exitosamente");
        return back();
    }

    public function setEstadoTicket(Request $request, $id)
    {
        $ticket = Tickets::find($id);
        $ticket->estado = $request->input('estado');
        $ticket->save();
        return $ticket->estado;
    }

    public function setGuardianTicket(Request $request, $id)
    {
        $ticket = Tickets::find($id);
        $ticket->guardian_id = $request->input('guardian_id');
        $ticket->save();
        \App\Funciones::sendMailNewGuardian(User::find($request->input('guardian_id')),User::find(Auth::user()->id),$ticket);
        return $ticket;
    }

    public function addComentarioTicket(Request $request)
    {
        $comentario = \App\Models\ComentariosTickets::create($request->input('comentario'));
        Flash::success("Comentario Agregado exitosamente");
        if($request->hasFile('archivo'))
        {
            $nombre = $comentario->id  . "." . $request->file("archivo")->getClientOriginalExtension();
            $request->file('archivo')->move(public_path("archivos/ComentariosTickets/"), $nombre );
            $comentario->archivo =  $request->file("archivo")->getClientOriginalName();
            $comentario->save();
        }
        if($request->exists('notificacion'))
        {
            \App\Funciones::sendMailNewComentario($request->input('emails'), $comentario);
        }

        if($request->ajax())
            return $comentario;
        else
            return  back();
    }

    public function deleteComentarioTicket(Request $request,$id)
    {
        $comentario = \App\Models\ComentariosTickets::find($id);
        if($comentario->user_id != Auth::user()->id)
        {
            abort(503);
        }
        $comentario->delete();
        return back();
    }

}
