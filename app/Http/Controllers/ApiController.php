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


    public function getProductos (Request $request){

		$request->session()->put('empresa',1);

		$referencia = (new  \App\Dbf(Funciones::getPathRef()));
		$productos = $referencia->paginate(12);
        $productos = $productos->toArray();

        foreach ($productos as $producto) {
          $producto["imagen"] = Funciones::getUrlProducto($producto);
          $array[] = $producto;
        }

		return \Response::json($array, 200);
	}

    public function doLogin (Request $request){

        $response = Auth::user();
        $response["img"] = Funciones::getUrlProfile();
        return $response;
    }

}
