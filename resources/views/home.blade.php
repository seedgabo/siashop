@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h4>Seleccione la Empresa: </h4>
        <div class="list-group col-md-6 col-md-offset-3">
        @forelse ($empresas as $empresa)
          <a class="list-group-item text-center" href="{{url('ajax/setEmpresa/'. $empresa->id)}}" onclick="setEmpresa({{$empresa->id}})">
            <img class="img-rounded" width="70px" src="{{$empresa->imagen()}}">
             <pre> Seleccionar {{$empresa->nombre}}</pre>
          </a>
        @empty
        @endforelse
        </div>
    </div>
</div>

@endsection
