<!--- Nombre Field --->
<div class="form-group col-sm-6">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
</div>

<!--- Descripción Field --->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('descripción', 'Descripción:') !!}
    {!! Form::textarea('descripción', null, ['class' => 'form-control']) !!}
</div>

<!--- User Id Field --->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::select('user_id[]', \App\User::lists("nombre","id"), null,['class' => 'form-control', 'Multiple' => 'Multiple']) !!}
</div>

<!--- Submit Field --->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('categoriasTickets.index') !!}" class="btn btn-default">Cancel</a>
</div>
