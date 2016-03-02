@extends('layouts.app')

@section('content')
	<div class="container">
	<h3>Seleccione el Cliente:</h3>	
	<div class="well">
			{{ Form::open(['method' => 'GET', 'class' => 'form-inline' , 'id' => "busquedaForm"]) }}		
			   <div class="form-group">
				   <div class="col-xs-9">
					    <select class="form-control" name="clave">
		   		    		<option value="NOM_TER">Nombre</option> 
		   		    		<option value="COD_TER">Codigo</option> 
		   		    		<option value="EMAIL">Email</option> 
		   		    		<option value="DIR1">Dirección</option> 
		   		    		<option value="TEL1">Telefono</option> 
		   		    	</select>
				   </div> 
			   </div>

			    <div class="form-group @if($errors->first('valor')) has-error @endif">
			        <div class="col-xs-9">
			        	{{ Form::text('valor',null, ['class' => 'form-control']) }}		        	
			        	<small class="text-danger">{{ $errors->first('valor') }}</small>
			    	</div>
			    </div>
			
			    <div class="form-group">
			        {{ Form::submit("Buscar", ['class' => 'btn btn-primary']) }}		    
			    </div>			
			{{ Form::close() }}
		</div>	
		<div class="list-group">
		<a class="list-group-item row">
				<span class="col-md-4 col-xs-12">Nombre</span>
				<span class="col-md-2 hidden-xs hidden-md">Codigo</span>
				<span class="col-md-2 hidden-xs hidden-md">Email</span>
				<span class="col-md-2 hidden-xs hidden-md">Direccion</span>
				<span class="col-md-2 hidden-xs hidden-md">Telefóno</span>
			</a>
		@forelse ($clientes as $cliente)
			<a href="{{url('ajax/setCliente/'.$cliente['COD_TER'])}}" class="list-group-item row">
				<span class="col-md-4 col-xs-12">{{$cliente['NOM_TER']}} </span>
				<span class="col-md-2 hidden-xs hidden-md">{{$cliente['COD_TER']}} </span>
				<span class="col-md-2 hidden-xs hidden-md">{{$cliente['EMAIL']}} </span>
				<span class="col-md-2 hidden-xs hidden-md">{{$cliente['DIR1']}} </span>
				<span class="col-md-2 hidden-xs hidden-md">{{$cliente['TEL1']}} </span>
			</a>
		@empty
			No hay Clientes
		@endforelse
		</div>
	</div>

@stop