@extends('layouts.app')

@section('content')
<div class="container">
	 {!! Form::open(['route' => ['Usuarios.store'], 'method' => 'POST', 'class' => 'form-horizontal col-md-6 col-md-offset-3 well']) !!}

	 	<div class="form-group @if($errors->first('nombre')) has-error @endif">
	 	    {!! Form::label('nombre', 'Nombre') !!}
	 	    {!! Form::text('nombre', null, ['class' => 'form-control', 'required' => 'required']) !!}
	 	    <small class="text-danger">{{ $errors->first('nombre') }}</small>
	 	</div>

	 	<div class="form-group @if($errors->first('email')) has-error @endif">
	 	    {!! Form::label('email', 'Email') !!}
	 	    {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'eg: foo@bar.com']) !!}
	 	    <small class="text-danger">{{ $errors->first('email') }}</small>
	 	</div>

		<div class="form-group @if($errors->first('cod_vendedor')) has-error @endif">
	 	    {!! Form::label('cod_vendedor', 'Codigo Vendedor') !!}
	 	    {!! Form::text('cod_vendedor', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'eg: foo@bar.com']) !!}
	 	    <small class="text-danger">{{ $errors->first('cod_vendedor') }}</small>
	 	</div>

	 	<div class="form-group{{ $errors->has('COD_CLI') ? ' has-error' : '' }}">
		    {!! Form::label('COD_CLI', 'Codigo de Cliente') !!}
		    {!! Form::text('COD_CLI', null, ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('COD_CLI') }}</small>
			<span class="text-danger">Dejar en blanco para vendedores</span>
		</div>

	   <div class="form-group">
	       <div class="checkbox @if($errors->first('clientes_propios')) has-error @endif">
	           <label for="clientes_propios">
	               {!! Form::checkbox('clientes_propios', '1', null, ['id' => 'clientes_propios']) !!} Solo mostrar clientes propios
	           </label>
	       </div>
	       <small class="text-danger">{{ $errors->first('clientes_propios') }}</small>
	   </div>

	   <div class="form-group">
	       <div class="checkbox @if($errors->first('admin')) has-error @endif">
	           <label for="admin">
	               {!! Form::checkbox('admin', '1', null, ['id' => 'admin']) !!} Administrador
	           </label>
	       </div>
	       <small class="text-danger">{{ $errors->first('admin') }}</small>
	   </div>


	   <div class="form-group @if($errors->first('empresas_id')) has-error @endif">
	       {!! Form::label('empresas_id', 'Empresas') !!}
	       {!! Form::select('empresas_id[]', App\Empresas::lists('nombre','id'), null, ['id' => 'empresas_id', 'class' => 'form-control chosen', 'required' => 'required', 'multiple']) !!}
	       <small class="text-danger">{{ $errors->first('empresas_id') }}</small>
	   </div>

	 	<div class="btn-group pull-right">

	 		{!! Form::submit("Guardar", ['class' => 'btn btn-success']) !!}
	 	</div>

	 {!! Form::close() !!}
</div>
@stop
