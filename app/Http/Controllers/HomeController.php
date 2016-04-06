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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Laracasts\Flash\Flash;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $empresas = Auth::user()->empresas();
        if(sizeof($empresas)>1 or Empresas::count()>1)
            return view('home')->withEmpresas($empresas);
        else
        {
            Flash::Warning("Solo una empresa Disponible");
            $request->session()->put('empresa', $empresas[0]->id);
            return redirect()->intended("menu");
        }
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

    public function cartera (Request $request)
    {
        $cartera =  (new \App\Dbf(Funciones::getPathCar()));

         $porcliente= $cartera->get()->groupBy('COD_TER');
         $total = $cartera->get()->sum("SALDO");
        foreach ($porcliente as  $COD_TER => $clientes)
        {
            $cliente[$COD_TER] = $clientes[0];
            $cliente[$COD_TER]["TOTAL"] = $clientes->sum("SALDO");
            $cliente[$COD_TER]["SIN_VEN"] = $clientes->sum("SIN_VEN");
            $cliente[$COD_TER]["A130"] = $clientes->sum("A130");
            $cliente[$COD_TER]["A3160"] = $clientes->sum("A3160");
            $cliente[$COD_TER]["A6190"] = $clientes->sum("A6190");
            $cliente[$COD_TER]["A91120"] = $clientes->sum("A91120");
            $cliente[$COD_TER]["MAS120"] = $clientes->sum("MAS120");
        }
        return view("cartera")->withCartera($cliente)->withTotal($total);
    }

    public function porCliente (Request $request, $codigo)
    {
        $cartera =  (new \App\Dbf(Funciones::getPathCar()));

        $cliente= $cartera->where("COD_TER" , $codigo)->get();

        return view("carteraPorCliente")->withCartera($cliente);
    }

    public function profile (Request $request)
    {
        $qr = array("email" => Auth::user()->email, "dominio" => url(""), "password" => "");
        $qr = json_encode($qr);
        return view('profile')->withUser(Auth::user())->withQr($qr);
    }

    public function profileUpdate (Request $request)
    {
        $user = Auth::user();
        $user->nombre =  $request->input('nombre');
        $user->email =  $request->input('email');
        $user->save();
        if($request->hasFile('photo'))
        {
            array_map('unlink', glob(public_path("img/users/". $user->id .".*")));
            $request->file('photo')->move(public_path('img/users/'), $user->id ."." . $request->file('photo')->getClientOriginalExtension());
        }
        if($request->has('password'))
        {
            if (!Hash::check($request->input('oldpassword'), Auth::user()->password)) {
                Flash::Error('La contraseña no coincide con la actual');
                return back();
            }
            if ($request->input('password') != $request->input('password_confirm')) {
                Flash::Error('Las contraseñas no coinciden');
                return back();
            }
            $user->password = Hash::make($request->input('password'));
            $user->save();
            Flash::Success("Contraseña Actualizada");
            Funciones::sendMailPasswordChanged($user);
        }
        Flash::Success("Usuario actualizado correctamente");
        return  back();
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
        if(!in_array(Auth::user()->id , $ticket->categoria->user_id))
        {
            return view("errors/401");
        }
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
