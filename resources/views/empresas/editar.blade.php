@extends('layouts.app')

@section('content')
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
</div>
@stop