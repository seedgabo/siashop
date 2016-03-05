@extends('layouts.app')


@section('content')
 @if (!Auth::user())
 	<img src="{{asset('img/logo.png')}}" alt="">
	<div class="col-md-6 col-md-offset-3">
		<h1>Accesso a cartera Siasoft</h1>
		<a class="btn btn-primary btn-lg" href="{{asset('login')}}"><i class="fa fa-sign-in"></i> ENTRAR </a>
	</div>
 @else
  	<?php	header('Location: ' . url('/menu') ); exit; ?>
 @endif

@endsection
