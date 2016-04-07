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
    public function doLogin (Request $request){

        $response = Auth::user();
        $response["img"] = Funciones::getUrlProfile();
        return $response;
    }

    public function getEmpresas (Request $request){

        $empresas = Auth::user()->empresas();

		return \Response::json($empresas, 200);
	}

    public function getClientes (Request $request, $empresa){

        $request->session()->put('empresa',$empresa);

        $referencia = (new  \App\Dbf(Funciones::getPathCli()));
        $clientes = $referencia->get();
        $clientes = $clientes->toArray();

        return \Response::json($clientes, 200);
    }


    public function getProductos (Request $request, $empresa){

		$request->session()->put('empresa',$empresa);

		$referencia = (new  \App\Dbf(Funciones::getPathRef()));
        if ($request->input('p', -1) == -1)
        {
            $productos = $referencia->get();
        }
        else
        {
            $productos = $referencia->paginate(12);
        }
        $productos = $productos->toArray();

        foreach ($productos as $producto) {
          $producto["imagen"] = Funciones::getUrlProducto($producto);
          $array[] = $producto;
        }

		return \Response::json($array, 200);
	}



}
