<table class="table table-responsive">
    <thead>
    <th>Id</th>
			<th>Nombre</th>
			<th>Descripción</th>
			<th>Usuarios </th>
    <th width="50px">Acción</th>
    </thead>
    <tbody>
    @foreach($categoriasTickets as $categoriasTickets)
        <tr>
            <td>{!! $categoriasTickets->id !!}</td>
			<td>{!! $categoriasTickets->nombre !!}</td>
			<td>{!! $categoriasTickets->descripción !!}</td>
			<td>{!! implode(",",\App\user::whereIn("id",$categoriasTickets->user_id)->lists("nombre")->toArray()) !!}</td>
            <td>
                <a href="{!! route('categoriasTickets.edit', [$categoriasTickets->id]) !!}"><i class="glyphicon glyphicon-edit"></i></a>
                <a href="{!! route('categoriasTickets.delete', [$categoriasTickets->id]) !!}" onclick="return confirm('Estas seguro que deseas eliminar este CategoriasTickets?')">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>