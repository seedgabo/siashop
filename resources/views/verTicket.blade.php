@extends('layouts.app')
@section('content')
<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.1/css/fileinput.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.1/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.1/js/fileinput_locale_es.min.js"></script>

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
	<div class="col-md-8">
		<div class="panel panel-primary hover">
		   <div style="text-transform: uppercase;" class="panel-heading text-center">
	   		<p class="">{{$ticket->titulo}}
	    	<span class="label label-warning pull-right">{!! App\Models\CategoriasTickets::find($ticket->categoria_id)->nombre !!}</span>
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
				<div class="col-md-3 form-inline">
					{!! Form::label('estado', 'Estado:') !!}
	    			{!! Form::select('estado', ['abierto' => 'abierto', 'completado' => 'completado', 'en curso' => 'en curso', ' rechazado' => ' rechazado'], $ticket->estado, ['id'=> 'estado','class' => 'form-control chosen', 'onChange' => "cambiarEstado($ticket->id , this.value)"]) !!}
				</div>
				@if ($ticket->transferible == 1 || $ticket->guardian_id == Auth::user()->id)
				<div class="col-md-3 form-inline">
					{!! Form::label('guardian', 'Responsable:') !!}
	    			{!! Form::select('guardian',$ticket->categoria->users()->lists("nombre","id"), $ticket->guardian_id, ['id'=> 'estado','class' => 'form-control chosen', 'onChange' => "cambiarGuardian($ticket->id , this.value)"]) !!}
				</div>
				@endif
				@endif
				<p class="text-right"><span class="text-info">Creado por:</span> {{\App\User::find($ticket->user_id)->nombre}} <img src="{{App\Funciones::getUrlProfile(App\User::find($ticket->user_id))}}" alt="" class="img-circle" height="35px"></p>
				<p class="text-right"><span class="text-info">Asignado a:</span> {{\App\User::find($ticket->guardian_id)->nombre}} <img src="{{App\Funciones::getUrlProfile(App\User::find($ticket->guardian_id))}}" alt="" class="img-circle" height="35px"></p>
			</div>
			</div>
				<small class="pull-right" style="color:red">Vence el: {{\App\Funciones::transdate($ticket->vencimiento)}}</small>
		</div>
	</div>
	<div class="col-md-4 well hover" >
		<div class="list-group" style="overflow-y: scroll; max-height: 400px;">
			@forelse ($comentarios as $comentario)
			<div class="list-group-item">
				{!!$comentario->texto!!}
				<p class="text-right">
				{{App\User::find($comentario->user_id)->nombre}}
				<img src="{{App\Funciones::getUrlProfile(App\User::find($comentario->user_id))}}" alt="" class="img-circle" height="35px">
				@if (Auth::user()->id == $comentario->user_id)
				 <a class="btn btn-danger btn-xs" href="{{url('ajax/deleteComentarioTicket/'.$comentario->id)}}" title="Borrar Comentario" onclick="return confirm('¿esta seguro de que quiere eliminar este comentario?')"><i class="fa fa-trash"></i></a>
				@endif
				@if (isset($comentario->archivo) && $comentario->archivo != "")
					<br>
					<a href="{{$comentario->archivo()}}">{{$comentario->archivo}}</a>
				@endif
				</p>
			</div>
			<hr>
			@empty
				No hay comentarios <br><strong>Agrega el primero</strong>
			@endforelse
		</div>

		{!! Form::open(['method' => 'POST', 'url' => 'ajax/addComentarioTicket', 'class' => 'form-horizontal form-comentario', 'id' => 'form-comentario', "files" => "true"]) !!}
			<input type="hidden" name="comentario[ticket_id]" value="{{$ticket->id}}">
			<input type="hidden" name="comentario[user_id]" value="{{Auth::user()->id}}">
			<textarea rows="6" required="required" minlength="8" class="form-control" name="comentario[texto]" placeholder="Agrega aqui algun aporte para el ticket"></textarea>

				<button type="button" onclick="masOpciones();" class="btn btn-xs">Mas Opciones</button>
			<div id="input-avanced" style="display:none">

				<div class="form-group">
				    <div class="col-sm-offset-2 col-sm-9">
				        <div class="checkbox @if($errors->first('notificacion')) has-error @endif">
				            <label for="notificacion">
				                {!! Form::checkbox('notificacion', 'true', true, ['id' => 'notificacion']) !!} Enviar Correo
				            </label>
				        </div>
				        <small class="text-danger">{{ $errors->first('notificacion') }}</small>
				    </div>
				</div>

				<div class="form-group @if($errors->first('emails[]')) has-error @endif">
				    {!! Form::label('emails[]', 'Enviar a', ['class' => 'col-sm-4 control-label']) !!}
				    <div class="col-sm-8">
				    	{!! Form::select('emails[]',$ticket->categoria->users()->lists("nombre","id"),[$ticket->user_id,$ticket->guardian_id], ['id' => 'emails[]', 'class' => 'form-control chosen', 'required' => 'required', 'multiple']) !!}
				    	<small class="text-danger">{{ $errors->first('emails[]') }}</small>
					</div>
				</div>

				<div class="form-group @if($errors->first('archivo')) has-error @endif">
				    <div class="col-sm-12">
					    {!! Form::file('archivo',["class"=>"file-bootstrap", "accept" =>".xlsx,.xls,image/*,.doc, .docx.,.ppt, .pptx,.txt,.pdf,.zip,.rar"]) !!}
					    <p class="help-block">Solo imagenes, menores a 10Mb</p>
					    <small class="text-danger">{{ $errors->first('archivo') }}</small>
				    </div>
				</div>

			</div>


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

		function cambiarGuardian(id, guardian_id)
		{
			$.post("{{url('ajax/setGuardianTicket/')}}" +"/" + id, {guardian_id: guardian_id},
				function(data)
				{
					$.toast({
	            		heading: 'Hecho',
	            		text: "Guardian Transferido",
	            		showHideTransition: 'slide',
	            		icon: 'info',
	            		position: 'mid-center',
    			});
    		})
		}

		function masOpciones()
		{
			$('#input-avanced').fadeToggle('slow');
			$('.chosen').chosen('destroy').chosen();
		}

		$(document).ready(function() {
			$('#form-comentario').submit(function(event) {
				$.toast({
	            		heading: '<h3 class="text-center">Enviando Comentario <br> <i class="fa fa-spinner fa-pulse"></i></h3>',
	            		text: '',
	            		showHideTransition: 'slide',
	            		icon: 'info',
	            		position: 'mid-center',
	            	})
				})

		    $(".file-bootstrap").fileinput({
		        maxFileSize: 10000,
				showUpload: false,
		        browseClass: "btn btn-success",
		        browseLabel: "Agregar",
		        browseIcon: "<i class=\"glyphicon glyphicon-upload\"></i> ",
				previewFileType: "image",
		        browseClass: "btn btn-success",
		        browseLabel: "Agregar",
		        browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
		        removeClass: "btn btn-danger",
		        removeLabel: "",
		        removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
		        uploadClass: "btn btn-info",
			});
		});

	</script>
</div>
@stop
