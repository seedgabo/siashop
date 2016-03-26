@extends('layouts.app')

@section('header')
 <link rel="stylesheet" href="{{asset('css/lightbox.min.css')}}">
@stop
@section('content')
	<div class="container">
		<div class="well">
			{{ Form::open(['method' => 'GET', 'class' => 'form-inline' , 'id' => "busquedaForm"]) }}
			   <div class="form-group">
				   <div class="col-xs-9">
					    <select class="form-control" name="clave">
		   		    		<option value="NOM_REF">Nombre</option>
		   		    		<option value="COD_REF">Codigo</option>
		   		    		<option value="VAL_REF">Precio</option>
		   		    	</select>
				   </div>
			   </div>

			    <div class="form-group @if($errors->first('NOM_REF')) has-error @endif">
			        <div class="col-xs-9">
			        	{{ Form::text('valor',null, ['class' => 'form-control']) }}
			        	<small class="text-danger">{{ $errors->first('NOM_REF') }}</small>
			    	</div>
			    </div>

			    <div class="form-group">
			        {{ Form::submit("Buscar", ['class' => 'btn btn-primary']) }}
			    </div>
			{{ Form::close() }}
		</div>


		<div class="text-center">
			{!! $paginator !!}
		</div>

		<?php $i=0; ?>
		@forelse ($productos as $producto)
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="well text-center hover" width="100%">
					<a href="{{ App\Funciones::getUrlProducto($producto) }}" data-lightbox='{{$producto["NOM_REF"]}}' data-title='{{$producto["NOM_REF"]}}'>
					<img src="{{ App\Funciones::getUrlProducto($producto) }}" height="250px"  width="100%" alt="Imagen no Disponible">
					</a>
					<h5>{{str_limit($producto["NOM_REF"],30)}}</h5>
					<p>{{number_format($producto["VAL_REF"],2,",",".") }} $</p>
					{!! Form::open(['method' => 'POST', 'url' => url('ajax/addCarrito'), 'class' => 'row form-inline form-product']) !!}
						<input id="{{$i}}" type="hidden" class="form-control input-sm" name="VAL_REF" value="{{$producto['VAL_REF']}}" step=".01">
						<input type="hidden" name="COD_REF" value="{{$producto['COD_REF']}}">
						<input type="hidden" name="NOM_REF" value="{{$producto['NOM_REF']}}">
						<input type="hidden" name="COD_CLI" value="{{Session::get('cliente')}}">
						<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
						<input type="hidden" name="empresa_id" value="{{$empresa->id}}">
						<input class="form-control input-sm" type="number" name="cantidad" value="0" min="1">
						<br><br>
						<input class="btn btn-sm btn-info" type="submit" value="Agregar al Carrito">
					</form>
					<small>{{$producto["COD_REF"]}}</small>
					<p class="text-right">
						<small>
                        @if($empresa->cantidad_global)
							Existencia: {{$producto['EXISTENCIA']}} <br>
							Pedidos: {{$producto['SALD_PED']}} <br>
                        @endif
                        @if($empresa->precio_global)
							<button onclick="$('#{{$i++}}').attr('type','number'); $(this).hide()" class="btn btn-xs"> Editar precio </button>
                        @endif
						</small>
					</p>
				</div>
			</div>
		@empty
			No Hay Productos
		@endforelse

		<div class="text-center">
			{!! $paginator !!}
		</div>
	</div>
	<script>
		$(document).ready(function() {
            // bind 'myForm' and provide a simple callback function
            $('.form-product').ajaxForm(function(data) {
            	$.toast({
            		heading: 'Producto '+ data +' Agregado al Carrito ',
            		text: "<br><br><a href='{!!url('/carrito')!!}'><h3> ir al  <i class='fa fa-cart-plus'> Carrito </h3></a>",
            		showHideTransition: 'slide',
            		icon: 'success',
            		position: 'top-center',
    				stack: false
            	})
            });
        });
	</script>
@stop
