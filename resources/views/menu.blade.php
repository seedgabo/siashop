@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h3>{{$empresa->nombre}}</h3>
    <div class="panel panel-success col-md-8 col-md-offset-2">
      <div class="panel-body">
        <h4>App para Android</h4>
         <div class="col-md-6">
              <a href="https://play.google.com/store/apps/details?id=com.seedgabo.siaphone2" target="_blank"><i class="fa fa-android"></i> Descargar</a>
         </div>
         <div class="col-md-6">
             <a href="profile#apps"> <i class="fa fa-info"></i> Como usar </a>
         </div>
      </div>
    </div>
    <h4>{{$cliente['NOM_TER'] or '' }}</h4>
        <div class="col-md-6">
                <div class="panel panel-info hover">
                    <div class="panel-body text-center">
                      <a href="{{url('cartera')}}">
                        <img src="{{asset('img/cartera.jpg')}}" height="200" alt="">
                        <h5>Cartera</h5>
                      </a>
                    </div>
                </div>
            </div>
            @if (Session::has('cliente'))
              <div class="col-md-6">
                  <div class="panel panel-info hover">
                      <div class="panel-body text-center">
                        <a href="{{url('catalogo-lista')}}">
                          <img src="{{asset('img/ventas-lista.png')}}" height="200" alt="">
                          <h5>Ventas en Lista</h5>
                        </a>
                      </div>
                  </div>
              </div>
             <div class="col-md-6">
                <div class="panel panel-info hover">
                    <div class="panel-body text-center">
                      <a href="{{url('catalogo')}}">
                        <img src="{{asset('img/ventas.png')}}" height="200" alt="">
                        <h5>Ventas en Catalogo</h5>
                      </a>
                    </div>
                </div>
            </div>
            @else
            <div class="col-md-6">
                <div class="panel panel-info hover">
                    <div class="panel-body text-center">
                      <a href="{{url('clientes')}}">
                        <img src="http://www.foromarketing.com/sites/default/files/fotos/vendedores%5B1%5D.png" height="200" alt="">
                        <h5>Seleccionar Cliente</h5>
                      </a>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-6">
                <div class="panel panel-info hover">
                    <div class="panel-body text-center">
                      <a href="{{url('carrito')}}">
                        <img src="{{asset('img/carrito.png')}}" height="200" alt="">
                        <h5>Carrito</h5>
                      </a>
                    </div>
                </div>
            </div>
             <div class="col-md-6">
                <div class="panel panel-info hover">
                    <div class="panel-body text-center">
                      <a href="{{url('ticket')}}">
                        <img src="{{asset('img/tickets.jpg')}}" height="200" alt="">
                        <h5>Matriz de Seguimiento</h5>
                      </a>
                    </div>
                </div>
            </div>
</div>

@stop