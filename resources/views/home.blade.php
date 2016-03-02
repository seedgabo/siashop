@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        <h4>Seleccione la Empresa: </h4>
        @forelse ($empresas as $empresa)
      <div class="col-md-6 text-center hover" style="margin-top: 10px;">
          <a href="{{url('ajax/setEmpresa/'. $empresa->id)}}" onclick="setEmpresa({{$empresa->id}})"> 
         <img src="{{asset('img/empresas/'. $empresa->id .'.jpg')}}" width="100%" alt="">
           <button class="btn btn-default btn-lg  btn-default btn-block">
              Seleccionar {{$empresa->nombre}}
           </button> 
           </a>
      </div>
        @empty
        @endforelse
        </div>
    </div>
</div>
@endsection
