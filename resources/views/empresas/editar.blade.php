@extends('layouts.app')

@section('content')

<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.1/css/fileinput.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.1/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.1/js/fileinput_locale_es.min.js"></script>
<div class="container">
	
	 {!! Form::model($empresa, ['route' => ['Empresa.update', $empresa->id], 'method' => 'PUT', 'class' => 'form-horizontal col-md-6 col-md-offset-3 well']) !!}
	 	
	 	<div class="form-group @if($errors->first('nombre')) has-error @endif">
	 	    {!! Form::label('nombre', 'Nombre de la Empresa') !!}
	 	    {!! Form::text('nombre', null, ['class' => 'form-control', 'required' => 'required']) !!}
	 	    <p class="help-block">Nombre de la Empresa</p>
	 	    <small class="text-danger">{{ $errors->first('nombre') }}</small>
	 	</div>

	 	<div class="form-group @if($errors->first('direccion_base_de_datos')) has-error @endif">
	 	    {!! Form::label('direccion_base_de_datos', 'Dirección donde se encuentra la base de datos') !!}
	 	    {!! Form::text('direccion_base_de_datos', null, ['class' => 'form-control', 'required' => 'required']) !!}
	 	    <p class="help-block">Dirección de la tablas, si desconoce su uso no modifique este dato</p>
	 	    <small class="text-danger">{{ $errors->first('direccion_base_de_datos') }}</small>
	 	</div>

	 	<div class="form-group @if($errors->first('direccion_tabla_clientes')) has-error @endif">
	 	    {!! Form::label('direccion_tabla_clientes', 'Dirección donde se encuentra la base de datos de clientes:') !!}
	 	    {!! Form::text('direccion_tabla_clientes', null, ['class' => 'form-control', 'required' => 'required']) !!}
	 	    <p class="help-block">Dirección de la tabla de clientes, si desconoce su uso no modifique este dato</p>
	 	    <small class="text-danger">{{ $errors->first('direccion_tabla_clientes') }}</small>
	 	</div>

	 	<div class="form-group @if($errors->first('emails')) has-error @endif">
	 	    {!! Form::label('emails', 'Emails para el envio de información') !!}
	 	    {!! Form::text('emails', implode(",",$empresa->emails), ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'eg: foo@bar.com']) !!}
	 	    <p class="help-block">Dirección de correo  a los que se desea enviar un email cada vez que se realize una transacción <br>
	 	     <span class="text-danger">Correos deben estar separados por comas y sin espacios</span></p>
	 	    <small class="text-danger">{{ $errors->first('emails') }}</small>
	 	</div>
	     
	 
	 	<div class="btn-group pull-right">
	 		
	 		{!! Form::submit("Guardar", ['class' => 'btn btn-success']) !!}
	 	</div>
	 
	 {!! Form::close() !!}


	 {!! Form::open(['method' => 'POST', 'url' => 'cargarImagenes/' . $empresa->id, 'class' => 'form-horizontal col-md-6 col-md-offset-3 well' , 'files' => true]) !!}
	 
		<div class="form-group{{ $errors->has('imagenes[]') ? ' has-error' : '' }}">
		    {!! Form::label('imagenes[]', 'Imagenes de productos', ['class' => 'col-sm-3 control-label']) !!}
		    <div class="col-sm-9">
			    {!! Form::file('imagenes[]', ['required' => 'required', "multiple" , "class" => "file-bootstrap", 'accept' => '.jpg,.zip']) !!}
			    <p class="help-block">Solo subir imagenes jpg, o archivos .zip que contengan las imagenes
				<span class="text-danger"> el nombre del archivo debe coincidir con el codigo del producto</span>
			    </p>
			    <small class="text-danger">{{ $errors->first('imagenes[]') }}</small>
		    </div>
		</div>	 
	 {!! Form::close() !!}
	<script>
	 	$(".file-bootstrap").fileinput({
		        maxFileSize: 10000,
		        languageS: 'es',
				showUpload: true,
		        dropZoneTitle : "Suelte aqui: .jpg o .zip",
		        browseClass: "btn btn-info",
		        browseLabel: "Agregar",
		        browseIcon: "<i class=\"glyphicon glyphicon-upload\"></i> ",
		        removeClass: "btn btn-danger",
		        removeLabel: "",
		        removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
		        uploadClass: "btn btn-info",
		        uploadLabel: "Subir",
		        uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> ",
		        uploadUrl: "{{url('upload/cargarImagenes/'. $empresa->id)}}", 
			    uploadAsync: false,
			    maxFileCount: 20
			}).on("filebatchselected", function(event, files) {
			    $(".file-bootstrap").fileinput("upload");
			});
	</script>
</div>
@stop