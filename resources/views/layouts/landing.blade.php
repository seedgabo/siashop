@extends('layouts.app')


@section('content')
 @if (!Auth::user())
 	{{-- <img src="{{asset('img/logo.png')}}" alt=""> --}}
	<a href="https://play.google.com/store/apps/details?id=com.seedgabo.siaphone2" title="Siasoft En Android" class="col-md-3 col-md-offset-3">
		<img src="http://jugaragario.com/wp-content/uploads/2015/08/agario-android.png" class="img-responsive" alt="Android apk">
	</a>
	<a href="#" class="toggle-instructions" title="Como usar=">¿Como Usar?</a>
	<div class="col-md-6 col-md-offset-3">
		<h1>Accesso a cartera Siasoft</h1>
		<a class="btn btn-primary btn-lg" href="{{asset('login')}}"><i class="fa fa-sign-in"></i> ENTRAR </a>
	</div>

	<div id="instructions" class="panel panel-primary col-md-12" style="display: none;">
		<div class="panel-body">
			 <ol>
			 	<li>Descarga la apicacion en android</li>
			 	<li>Entra en tu perfil en la pagina web. (En el panel de la izquierda, una vez hayas iniciado sesión)</li>
			 	<li>Escanea el codigo de barras</li>
			 </ol>
		</div>
	</div>

	<script>
		$(".toggle-instructions").click(function(){
              $("#instructions").toggle('fast');
		});
	</script>
 @else
  	<?php	header('Location: ' . url('/menu') ); exit; ?>
 @endif

@endsection
