<?php

namespace App\Http\Controllers;

use App\Carritos;
use App\Funciones;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Tickets;
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
            if ($request->ajax())
                return "true";
            else
            {
                Flash::success('Empresa Seleccionada');
                $request->session()->flash('success', "Empresa Seleccionada");
                return redirect('/menu');
            }
        }
        else
        {
            return  (new Response("No Autorizado", 401));
        }
    } 

    public function setCliente(Request $request, $cliente)
    { 
        $request->session()->put('cliente', $cliente);
        if ($request->ajax())
        {
            return "true";
        }
        else
        {
            Flash::success('Cliente Seleccionado');
            return redirect('menu');
        }
    }

    public function addCarrito(Request $request)
    {
        Carritos::create($request->all());
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
        $productos = Carritos::where('user_id',Auth::user()->id)
        ->where('COD_CLI',$request->session()->get('cliente'))
        ->get();
        Funciones::procesarCarrito($productos);
        $empresa = Funciones::getEmpresa();
        $cliente = Funciones::getCliente();        
        Funciones::sendMailProccessCarrito($productos, $empresa->emails, Auth::user() ,$empresa,$cliente);
        Funciones::borrarCarrito();
        
        if ($request->ajax())
            return "true";
        else
             Flash::success("Compra procesada");
            return  redirect('/carrito');
    }

    public function setEstadoTicket(Request $request, $id)
    {
        $ticket = Tickets::find($id);
        $ticket->estado = $request->input('estado');
        $ticket->save();
        return $ticket->estado;
    }

    public function addComentarioTicket(Request $request)
    {
        $comentario = \App\Models\ComentariosTickets::create($request->all());
        return $comentario;
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
