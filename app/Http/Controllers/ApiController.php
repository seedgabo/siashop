<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use  App\Dbf;
use  App\Funciones;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class ApiController extends Controller
{
    /**
     * [doLogin description]
     * @method doLogin
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function doLogin (Request $request){

        $response = Auth::user();
        $response["img"] = Funciones::getUrlProfile();
        return $response;
    }

    /**
     * [getEmpresas description]
     * @method getEmpresas
     * @param  Request     $request [description]
     * @return [type]               [description]
     */
    public function getEmpresas (Request $request){

        $empresas = Auth::user()->empresas();

        return \Response::json($empresas, 200);
    }

    /**
     * [getClientes description]
     * @method getClientes
     * @param  Request     $request [description]
     * @param  [type]      $empresa [description]
     * @return [type]               [description]
     */
    public function getClientes (Request $request, $empresa){

        $request->session()->put('empresa',$empresa);
        $clientes = \App\Cliente::where("empresa_id",$empresa)->orWhereNull("empresa_id")->get();
        return \Response::json($clientes, 200);
    }

    /**
     * [getProductos description]
     * @method getProductos
     * @param  Request      $request [description]
     * @param  [type]       $empresa [description]
     * @return [type]                [description]
     */
    public function getProductos (Request $request, $empresa){
        $request->session()->put('empresa',$empresa);
        $query = \App\Producto::where("empresa_id",$empresa)->orWhereNull("empresa_id");
        if ($request->input('page', -1) == -1)
        {
            $productos = $query->get();
        }
        else
        {
            $productos = $query->paginate(50);
        }

        foreach ($productos as $producto) {
          $producto->imagen = Funciones::getUrlProducto($producto);
          $array[] = $producto;
        }
        return $productos;
    }


    public function searchProducto (Request $request, $empresa){
        $request->session()->put('empresa',$empresa);
        $query = \App\Producto::where("empresa_id",$empresa);
        $query  = $query->where(function($q) use($request){
            $q->orWhere("COD_REF", "LIKE", "%". $request->input("query","") ."%");
            $q->orWhere("NOM_REF", "LIKE", "%". $request->input("query","") ."%");
            $q->orWhere("COD_TIP", "LIKE", "%". $request->input("query","") ."%");
        });

        $productos = $query->paginate(50);


        foreach ($productos as $producto) {
          $producto->imagen = Funciones::getUrlProducto($producto);
          $array[] = $producto;
        }
        return $productos;
    }

    public function producto(Request $request, $cod){
        $producto = \App\Producto::where("COD_REF","=",$cod)->first();
        $producto->imagen = Funciones::getUrlProducto($producto);
        return $producto;
    }


    /**
     * [getCartera description]
     * @method getCartera
     * @param  Request    $request [description]
     * @param  int        $empresa [description]
     * @return [type]              [description]
     */
    public function getCartera (Request $request, $empresa){

        $request->session()->put('empresa',$empresa);
        $query = \App\Cartera::where("empresa_id",$empresa)->orWhereNull("empresa_id");
        if ($request->input('page', -1) == -1)
        {
            $cartera = $query->get();
        }
        else
        {
            $cartera = $query->paginate(12);
        }
        return \Response::json($cartera->toArray(), 200);
    }

    public function procesarCarrito(Request $request, $empresa){
        $request->session()->put('empresa',$empresa);
        $data = ($request->all());
        $response = "";
        foreach ($data as $producto) {
             $response .=  $producto['NOM_REF'] . "<br>";
        }
        return json_encode(["result" => $response]);
    }

}
