<?php

namespace App\Http\Controllers;
use App\Carritos;
use App\Dbf;
use App\Empresas;
use App\Funciones;
use App\Http\Requests;
use App\Models\CategoriasTickets;
use App\Models\ComentariosTickets;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $empresas = Auth::user()->empresas();
        return view('home')->withEmpresas($empresas);
    }

    public function menu(Request $request)
    {
        $empresa =  Funciones::getEmpresa();
        return view('menu')->withEmpresa($empresa);
    }

    public function catalogo(Request $request)
    {
        $empresa = Funciones::getEmpresa();
        $referencia = (new  Dbf(Funciones::getPathRef()));
        if (Input::has('valor'))
            $productos = $referencia->where(Input::get('clave'), Input::get('valor'))->paginate(15);
        else
            $productos = $referencia->paginate(12);

        return view('catalogo')->withEmpresa($empresa)->withProductos($productos)->withPaginator($referencia->links());
    }

    public function clientes(Request $request)
    {        
        if (Input::has('valor'))
            $clientes = (new Dbf(Funciones::getPathCli()))->where(Input::get('clave'), Input::get('valor'))->get();
        else
            $clientes = (new Dbf(Funciones::getPathCli()))->get();

        return view('clientes')->withClientes($clientes);
    }

    public function carrito(Request $request)
    {
        $cliente =  Funciones::getCliente();
        $empresa =  Funciones::getEmpresa();
        $carrito =  Carritos::CarritoActual();
        return view('carrito')->withEmpresa($empresa)->withCarrito($carrito)->withCliente($cliente);
    }

    public function tickets(Request $request)
    {
        $categorias =  CategoriasTickets::byUser();
        $tickets = Tickets::where('estado',"<>","completado")
        ->whereIn("categoria_id",$categorias->pluck("id"))
        ->orderBy("categoria_id","asc")
        ->orderBy("created_at")
        ->get();
        return  view('tickets')->withTickets($tickets);    
    }

    public function misTickets(Request $request)
    {
        $tickets= Tickets::where("user_id",Auth::user()->id)
        ->orderBy("categoria_id","asc")
        ->orderBy("created_at")
        ->get();
        return  view('tickets')->withTickets($tickets);    
    }

    public function todostickets(Request $request)
    {
        if(Auth::user()->admin != 1)
        {
            $categorias =  CategoriasTickets::byUser();
            $tickets = Tickets::whereIn("categoria_id",$categorias->pluck("id"))
            ->get();
        }
        else
        {
            $tickets = Tickets::all();
        }
        return  view('tickets')->withTickets($tickets);    
    }
    
    public function ticketVer(Request $request, $id)
    {
        $ticket= Tickets::find($id);
        $comentarios = ComentariosTickets::where("ticket_id",$ticket->id)
        ->orderBy("created_at")
        ->get();
        return view("verTicket")->withTicket($ticket)->withComentarios($comentarios);
    }

    public function ticketEliminar(Request $request, $id)
    {
        $ticket =Tickets::find($id);
        if($ticket->user_id == Auth::user()->id || Auth::user()->admin ==1 )
        {
            $ticket->delete();
        }
        else
        {
            \Flash::error("no los permisos necesarios tiene permisos");
        }
        return back();
    }
}
