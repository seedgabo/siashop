@extends('layouts.app')
@section('content')

<div class="container-fluid">
<div class="text-center">
	<ol class="breadcrumb">
		<li>
			<a href="{{url('ticket')}}">Tickets Abiertos</a>
		</li>
		<li>
			<a href="{{url('mis-tickets')}}">mis Tickets</a>
		</li>
		<li> <a href="{{url('tickets/todos')}}">Todos los Tickets </a></li>

		<li class="active">{{$ticket->titulo}}</li>
	</ol>
</div>
	<div class="col-md-9">
		<div class="panel panel-primary">
		   <div style="text-transform: uppercase;" class="panel-heading text-center">
	   		<p class="">{{$ticket->titulo}}
		    	<span class="pull-right"><b>Categoría:</b> {!! App\Models\CategoriasTickets::find($ticket->categoria_id)->nombre !!}</span>
	   		</p>
		   </div>
			<div class="panel-body">
				{!! $ticket->contenido !!}
				@if ($ticket->archivo!= '' || $ticket->archivo != null)
					<h4 class="text-right"><a href="{{$ticket->archivo()}}"><i class="ion-android-attach"></i> ver Adjunto</a></h4>
				@endif
			</div>
			<div class="panel-footer">
			<div class="container-fluid">
				@if (Auth::user()->id == $ticket->guardian_id || Auth::user()->id == $ticket->user_id)
				<div class="col-md-4 form-inline">
					{!! Form::label('estado', 'Estado:') !!}
	    			{!! Form::select('estado', ['abierto' => 'abierto', 'completado' => 'completado', 'en curso' => 'en curso', ' rechazado' => ' rechazado'], $ticket->estado, ['id'=> 'estado','class' => 'form-control chosen', 'onChange' => "cambiarEstado($ticket->id , this.value)"]) !!}
				</div>
				@if ($ticket->transferible == 1)
				<div class="col-md-4 form-inline">
					{!! Form::label('guardian', 'Guardian:') !!}
	    			{!! Form::select('guardian',\App\User::lists("nombre","id"), $ticket->estado, ['id'=> 'estado','class' => 'form-control chosen', 'onChange' => "cambiarGuardian($ticket->id , this.value)"]) !!}
				</div>
				@endif
				@endif
				<p class="text-right">Creado por: {{\App\USer::find($ticket->user_id)->nombre}}</p>
				<p class="text-right">Asignado a {{\App\USer::find($ticket->guardian_id)->nombre}}</p>
			</div>
			</div>
				<small class="pull-right" style="color:red">Vence el: {{\App\Funciones::transdate($ticket->vencimiento->format('l j \d\e F \d\e Y h:i:s A'))}}</small>
		</div>
	</div>
	<div class="col-md-3 well hover">
		@forelse ($comentarios as $comentario)
			<div class="list-group">
			<div class="list-group-item">
				{!!$comentario->texto!!}
				<p class="text-right">
				{{App\User::find($comentario->user_id)->nombre}}
				@if (Auth::user()->id == $comentario->user_id)
				 <a class="btn btn-danger btn-xs" href="{{url('ajax/deleteComentarioTicket/'.$comentario->id)}}" title="Borrar Comentario" onclick="return confirm('¿esta seguro de que quiere eliminar este comentario?')"><i class="fa fa-trash"></i></a>
				@endif
				</p>
			</div>
			</div>
		@empty
			No hay comentarios <br><strong>Agrega el primero</strong>
		@endforelse
		<hr><hr>
		
		{!! Form::open(['method' => 'POST', 'url' => 'ajax/addComentarioTicket', 'class' => 'form-horizontal', 'id' => 'form-comentario']) !!}
			<input type="hidden" name="ticket_id" value="{{$ticket->id}}">
			<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
			<textarea class="form-control" name="texto" placeholder="Agrega aqui algun aporte para el ticket"></textarea>		
			<br>
			<div class="text-right">
	        	{!! Form::submit("Enviar", ['class' => 'btn btn-success']) !!}		
			</div>
		{!! Form::close() !!}
	</div>
	<script>
		function cambiarEstado(id, estado)
		{
			$.post("{{url('ajax/setEstadoTicket/')}}" +"/" + id, {estado: estado}, 
			function(data)
			{
				$.toast({
            		heading: 'Hecho',
            		text: "Estado Actualizado",
            		showHideTransition: 'slide',
            		icon: 'success',
            		position: 'mid-center',
            	})
				$("#estado").val(data);
			})
		}
		$(document).ready(function() { 
			$('#form-comentario').ajaxForm(function(data) {
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
</div>
@stop