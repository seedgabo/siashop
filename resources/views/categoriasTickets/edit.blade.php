@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Guardar CategoriasTickets</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($categoriasTickets, ['route' => ['categoriasTickets.update', $categoriasTickets->id], 'method' => 'patch']) !!}

            @include('categoriasTickets.fields')

            {!! Form::close() !!}
        </div>
    </div>
@endsection