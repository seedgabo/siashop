@extends('layouts.app')
@section('content')
	<div class="container">
	<div class="text-right">
		<a class="btn btn-primary" data-toggle="modal" href='#modal-ticket'><i class="fa fa-plus"></i> Crear un ticket</a>
	</div>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>Ticket</th>
					<th>Categoría</th>
					<th>Estado</th>
					<th>contenido</th>
					<th>Archivo</th>
				</tr>
			</thead>
			<tbody>
			 @forelse ($tickets as $ticket)
				<tr class="@if($ticket->estado == "completado") success @endif @if($ticket->estado == "rechazado") danger @endif @if($ticket->estado == "en curso") info @endif @if($ticket->estado == "abierto") warning @endif">
					<td>
						<a class="btn btn-link" style="text-transform: uppercase;" href="{{url("ticket/ver/".$ticket->id)}}"> {{$ticket->titulo}}</a>
						@if ($ticket->user_id == Auth::user()->id)
							<a class="btn pull-right btn-xs btn-danger" onclick="return confirm('esta seguro de que desea eliminar este ticket?')" href="{{url("ticket/eliminar/".$ticket->id)}}"> <i class="fa fa-trash"></i></a>
						@endif
					</td>
					<td>{{\App\Models\categoriasTickets::find($ticket->categoria_id)->nombre}}</td>
					<td>{{$ticket->estado}}</td>
					<td>{{str_limit($ticket->contenido,100)}}</td>
					<td>
					@if ($ticket->archivo == null || $ticket->archivo == '')
						No Posee
					@else
						<a class="btn btn-success btn-xs" href="{{$ticket->archivo()}}">Ver</a>
					@endif</td>
				</tr>
			 @empty
			 	Ningún ticket existente
			 @endforelse
			</tbody>
		</table>
	</div>

	<div class="modal fade" id="modal-ticket">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-ticket"></i> Nuevo Ticket</h4>
				</div>
				<div class="modal-body">
				<div class="row">
					
				{!! Form::open(['method' => 'POST', 'route' => 'tickets.store', 'class' => 'form-horizontal col-md-10 col-md-offset-1' ,'id' => 'nuevoTicket', 'files'=>true]) !!}
					<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
					<input type="hidden" name="estado" value="abierto">
				    <div class="form-group @if($errors->first('titulo')) has-error @endif">
				        {!! Form::label('titulo', 'Titulo') !!}
				        {!! Form::text('titulo', null, ['class' => 'form-control', 'required' => 'required']) !!}
				        <small class="text-danger">{{ $errors->first('titulo') }}</small>
				    </div>

				    <div class="form-group @if($errors->first('contenido')) has-error @endif">
				        {!! Form::label('contenido', 'Contenido') !!}
				        {!! Form::textarea('contenido', null, ['class' => 'form-control', 'required' => 'required']) !!}
				        <small class="text-danger">{{ $errors->first('contenido') }}</small>
				    </div>

				    <div class="form-group @if($errors->first('categoria_id')) has-error @endif">
				        {!! Form::label('categoria_id', 'Categoria') !!}
				        {!! Form::select('categoria_id',\App\Models\CategoriasTickets::byuser()->lists("nombre","id"), null, ['id' => 'categoria', 'class' => 'form-control', 'required' => 'required']) !!}
				        <small class="text-danger">{{ $errors->first('categoria_id') }}</small>
				    </div>

				    <div class="form-group @if($errors->first('archivo')) has-error @endif">
				        {!! Form::label('archivo', 'Archivo') !!}
				        {!! Form::file('archivo', []) !!}
				        <p class="help-block">El archivo debe pesar menos de 10Mb</p>
				        <small class="text-danger">{{ $errors->first('archivo') }}</small>
				    </div>
				
				
				{!! Form::close() !!}
					
				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			        {!! Form::submit("Agregar", ['class' => 'btn btn-success' , 'form' => 'nuevoTicket']) !!}
				</div>
			</div>
		</div>
	</div>

	<script>
	$(document).ready(function() { 
			$('#nuevoTicket').ajaxForm(function(data) {
				$.toast({
	            		heading: 'Hecho',
	            		text: data,
	            		showHideTransition: 'slide',
	            		icon: 'success',
	            		position: 'mid-center',
	            	})
				$("textarea").html();
				$("textarea").val();
				location.reload(); 
			});
		});
	</script>
@stop