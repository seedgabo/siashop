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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
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

    public function catalogo(Request $request){

        $empresa = $request->session()->get('empresa');

        $query =  \App\Producto::orderBy($request->get("orden","NOM_REF"),$request->get("orden_dir","asc"));

        if (Input::has('valor') && Input::get('valor') != '')
            $query->where(Input::get('clave'), "like" ,"%" . Input::get('valor') . "%");

        if($request->exists('cod_tip') && $request->input('cod_tip') != '')
            $query->where("cod_tip","=",$request->input('cod_tip'));

        if($request->exists('cod_gru') && $request->input('cod_gru') != '')
            $query->where("cod_gru","=",$request->input('cod_gru'));

        $query->where("empresa_id",$empresa)->orWhereNull("empresa_id");
        $productos = $query->paginate(21);

        $lineas = DB::table('mae_tip')->where("empresa_id", $empresa)->lists("nom_tip","cod_tip");
        $grupos = DB::table('mae_gru')->where("empresa_id", $empresa)->where("cod_tip","=",$request->input('cod_tip', ''))->lists("nom_gru","cod_gru");

        return view('catalogo')
        ->withEmpresa(\App\Empresas::find($empresa))
        ->withProductos($productos)
        ->withGrupos($grupos)
        ->withLineas($lineas);
    }

    public function catalogoLista(Request $request){

        $empresa = $request->session()->get('empresa');

        $query =  \App\Producto::orderBy($request->get("orden","productos.NOM_REF"),$request->get("orden_dir","asc"));

        $query->select("productos.*", "carritos.cantidad as cantidad");

        $query->where("productos.empresa_id",$empresa)->orWhereNull("productos.empresa_id");

        $query->leftJoin('carritos', function($join) use ($request, $empresa)
        {
            $join->on('carritos.user_id', '=', Db::raw(Auth::user()->id));
            $join->on('carritos.estado', '=', Db::raw("0"));
            $join->on('carritos.COD_CLI', '=', Db::raw("'". $request->session()->get('cliente') . "'"));
            $join->on('carritos.COD_REF', '=', "productos.COD_REF");
            $join->on('carritos.empresa_id', '=', Db::raw($empresa));
        });

        $productos = $query->get();

        // return $productos;

        $lineas = DB::table('mae_tip')->where("empresa_id", $empresa)->lists("nom_tip","cod_tip");
        $grupos = DB::table('mae_gru')->where("empresa_id", $empresa)
                  ->where("cod_tip","=",$request->input('cod_tip', ''))->lists("nom_gru","cod_gru");

        foreach ($productos as $producto) {
          $producto->imagen = Funciones::getUrlProducto($producto);
          $array[] = $producto;
        }

        return view('lista-catalogo')
        ->withEmpresa(\App\Empresas::find($empresa))
        ->withProductos($productos)
        ->withGrupos($grupos)
        ->withLineas($lineas);
    }

    public function clientes(Request $request)
    {
        if (Auth::user()->COD_CLI  != "") {
            $request->session()->put("cliente", Auth::user()->COD_CLI);
            Flash::Warning("Usuario del Tipo Cliente");
            return redirect("catalogo");
        }

        $empresa = $request->session()->get('empresa');

        $query = \App\Cliente::select("*");
        $query->where(function($q) use ($empresa){
            $q->where("empresa_id",$empresa)
              ->orWhereNull("empresa_id");
         });

        if (Input::has('valor'))
            $query->where(Input::get('clave'), "like" , "%".Input::get('valor')."%");

        if(Auth::user()->clientes_propios  == "1")
        {
            $query->where("COD_VEN","=",Auth::user()->cod_vendedor);
            Flash::Warning("Mostrando Cartera Propia");
        }
        // return $query->toSql();
        $clientes = $query->orderby("NOM_TER","asc")->paginate(100);
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
        $empresa = $request->session()->get("empresa");
        if (Auth::user()->COD_CLI != "") {
            $cartera =  \App\Cartera::where("COD_TER", Auth::user()->COD_CLI)->where("empresa_id",$empresa)->orWhereNull("empresa_id")->get();
        }
        else {
            $cartera =  \App\Cartera::where("empresa_id",$empresa)->orWhereNull("empresa_id")
            ->orderby("NOM_TER","asc")->get();
        }

         $porcliente= $cartera->groupBy('COD_TER');
         $total = $cartera->sum("SALDO");
        if(sizeof($porcliente) > 1)
        {
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
        else
        {
            Flash::Warning("Mostrando solo la cartera del cliente " . Auth::user()->COD_CLI);
           return view("cartera")->withCartera($cartera)->withTotal($total);
        }

    }

    public function porCliente (Request $request, $codigo)
    {
        $cliente =  \App\Cartera::where("COD_TER",$codigo)->get();
        return view("carteraPorCliente")->withCartera($cliente);
    }

    public function profile (Request $request)
    {
        $qr = array("email" => Auth::user()->email, "url" => url(""), "token" => Crypt::encrypt(Auth::user()->id));
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
            \Flash::error("No tiene los permisos necesarios");
        }
        return back();
    }
}
