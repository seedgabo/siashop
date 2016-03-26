<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UploadController extends Controller
{
    public function  cargarImagenes(Request $request, $id)
    {
    	$empresa = \App\Empresas::find($id);
    	foreach ($request->file('imagenes') as $imagen) {
			$imagen->move(public_path() ."/img/".$id ."/productos", $imagen->getClientOriginalname());
    		if ($imagen->getClientOriginalExtension() == "zip")
    		{
                $zip = (new \Chumper\Zipper\Zipper)->make(public_path() ."/img/".$id ."/productos/" . $imagen->getClientOriginalname());
    			if ($zip) {
				    $zip
                    ->extractTo(public_path() ."/img/".$id ."/productos/");
				    return "true";
				}
				else
				{
					return "error";
				}	
    		}
    	}
    	return "true";
    }
}
