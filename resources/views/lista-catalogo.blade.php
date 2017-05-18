@extends('layouts.app')

@section('header')
<link rel="stylesheet" href="{{asset('css/lightbox.min.css')}}">
@stop
@section('content')
<div class="container" id="catalogo">
	<form class="form-inline">
		<div class="form-group">
			<label for="">Nombre</label>
			<input type="text" v-model="nombre" class="form-control">
		</div>
		<div class="form-group">
			<label for="lineas">Líneas</label>
			<select v-model="linea" class="form-control input-sm">
			<option value=""> Seleccionar </option>
			@forelse ($lineas as $id => $linea)
			 <option value="{{$id}}"> {{$linea}} </option>
			@empty
			@endforelse
			</select>
		</div>
		<div class="form-group">
			<label for="grupos">Grupos</label>
			<select v-model="grupo" class="form-control input-sm">
			@forelse ($grupos as $id => $grupo)
			 <option value="{{$id}}"> {{$grupo}} </option>
			@empty
			@endforelse
			</select>
		</div>
		<div class="form-group">
			<label for="grupos">Ordenar Por</label>
			<select v-model="orden" class="form-control input-sm">
			 <option value="NOM_REF" selected> Nombre </option>
			 <option value="COD_REF"> Codigo </option>
			 <option value="VAL_REF"> Precio </option>
			</select>
		</div>
	</form>
	<br>
	<a class="btn btn-warning" href="{{url('catalogo')}}">Ver En Catalogo</a>
	<a class="btn btn-warning" href="{{url('carrito')}}"> Ver Carrito</a>
	<br><br>
	<div class="table-responsive">
		<table class="table table-bordered table-compact table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Nombre</th>
					<th>Codigo</th>
					<th>Precio</th>
					<th>Cantidad</th>
					@if($empresa->cantidad_global)
					<th>Disponible</th>
					@endif
					<th>Pedidos</th>
					<th>Neto</th>
					<th>Observación</th>
					<th>Accion</th>
				</tr>
			</thead>

			<tbody>
				<tr v-for="producto in productos | filterBy nombre | filterBy linea in 'COD_TIP' | orderBy  orden " v-cloak>
					<td>@{{ producto.id }}</td>
					<td>@{{ producto.NOM_REF }}</td>
					<td>@{{ producto.COD_REF }}</td>
					<td style="width:120px"> 
						<span id="precio-@{{producto.id}}"> @{{ producto.VAL_REF }}</span>
						<input id="input-precio-@{{producto.id}}" style="display:none" type="number" v-model="producto.VAL_REF" class="form-control input-sm"/>   
					</td>
					<td style="width:120px">
						<input class="form-control input-sm" type="number" v-model="producto.cantidad" value="@{{producto.cantidad}}"  min="1" max="@{{producto.EXISTENCIA}}" />
					</td>
					@if($empresa->cantidad_global)
					<td>
						@{{producto.EXISTENCIA}}
					</td>
					@endif

					<td>
						@{{producto.SALD_PED}}						
					</td>
					<td>
						<input type="checkbox" name="neto" value="neto" v-model="producto.neto">
					</td>
					<td>
						<input type="text" name="nota" value="" v-model="producto.observacion">
					</td>				
					<td>

						<a class="btn btn-success" v-on:click="addToCart(producto)">
							<i class="fa fa-cart-plus"></i>  Agregar
						</a>
						<a href="@{{ producto.imagen }}" data-lightbox='roadtrip' data-title='@{{producto.NOM_REF}}' class="btn btn-primary">
							<i class="fa fa-picture-o"></i>  Ver
						</a>
						@if($empresa->precio_global)
						<a class="btn" v-on:click="toggleProducto(producto)">
							<i class="fa fa-pencil"></i>  Editar
						</a>
						@endif
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"></script>
<script src="{{asset('js/jquery.lazyload.min.js')}}"></script>
<script>
	$(document).ready(function() {
		$("img.lazy").lazyload({resizeDuration: 100, fadeDuration: 100});
	});
</script>
<script>
	new Vue({
		  el: '#catalogo',
		  data: {
		    productos: JSON.parse("{{$productos->toJson()}}".replace(/&quot;/g,'"'))
		  },  
		  methods: {
		    toggleProducto: function (producto) {
		    	$("#precio-"+ producto.id).toggle();
		    	$("#input-precio-"+ producto.id).toggle();
    		},
    		addToCart: function (producto){
    		 	$.post( "{{url('ajax/addCarrito')}}", 
    		 		{   VAL_REF: producto.VAL_REF,
    		 			COD_REF: producto.COD_REF,
    		 			NOM_REF: producto.NOM_REF,
    		 			neto: producto.neto ? 1 : 0,
    		 			COD_CLI: "{{Session::get('cliente')}}",
    		 			user_id: "{{Auth::user()->id}}",
    		 			COD_VEN: "{{Auth::user()->cod_vendedor}}",
    		 			empresa_id: "{{$empresa->id}}",
    		 			cantidad: producto.cantidad,
    		 			observacion: producto.observacion
    		 		}).done( function (data){
	 						$.toast({
							heading: 'Producto '+ data +' Agregado al Carrito ',
							text: "<br><br><a href='{!!url('/carrito')!!}'><h3> ir al  <i class='fa fa-cart-plus'> Carrito </h3></a>",
							showHideTransition: 'fade',
							icon: 'success',
							position: 'top-right',
							stack: false
						});
    		 		})
    		}
    	}
		});
</script>
@stop
