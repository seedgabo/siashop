<?php

use App\Funciones;



  	Route::any('/', function(){return redirect('/login');});
Route::group(['middleware' => 'web'], function () {
	Route::auth();
  	Route::get('/home', 'HomeController@index');
	Route::any('/menu',   ['middleware' => ['EmpresaSet'], 'uses' =>'HomeController@menu']);
	Route::any('/catalogo', ['middleware' => ['EmpresaSet','clienteSet'], 'uses' =>'HomeController@catalogo']);
	Route::any('/clientes', ['middleware' => ['EmpresaSet'], 'uses' =>'HomeController@clientes']);
	Route::any('/carrito',  ['middleware' => ['EmpresaSet','clienteSet'], 'uses' =>'HomeController@carrito']);

	Route::get('/ticket',   ['middleware' => ['EmpresaSet'], 'uses' =>'HomeController@tickets']);
	Route::get('/mis-tickets',   ['middleware' => ['EmpresaSet'], 'uses' =>'HomeController@misTickets']);
	Route::get('/tickets/todos',   ['middleware' => ['EmpresaSet'], 'uses' =>'HomeController@Todostickets']);
	Route::get('/ticket/ver/{id}',   ['middleware' => ['EmpresaSet'], 'uses' =>'HomeController@ticketVer']);
	Route::get('ticket/eliminar/{id}', ['middleware' => ['EmpresaSet'], 'uses' =>'HomeController@ticketEliminar']);
	
	Route::group(['prefix' => 'ajax'], function() {
			Route::any('/setEmpresa/{empresa}','AjaxController@setEmpresa');
			Route::any('/setCliente/{cliente}','AjaxController@setCliente');
			Route::any('/addCarrito','AjaxController@addCarrito');
			Route::any('/eliminarCarrito/{id}','AjaxController@deleteCarrito');
			Route::any('/eliminarCarrito','AjaxController@clearCarrito');
			Route::any('/procesarCarrito' , 'AjaxController@ProcesarCarrito');
			Route::any('/setEstadoTicket/{id}' , 'AjaxController@setEstadoTicket');
			Route::any('/addComentarioTicket' , 'AjaxController@addComentarioTicket');
			Route::any('/deleteComentarioTicket/{id}' , 'AjaxController@deleteComentarioTicket');
	});


	Route::group(['middleware' =>'isAdmin'], function() {
		Route::resource('Empresa', 'EmpresaController');
		Route::any('Empresa/delete/{id}', [
			'as' => 'usuario.delete',
			'uses' => 'EmpresaController@destroy'
			]);

		Route::resource('Usuarios', 'UsuarioController');
		Route::any('Usuarios/delete/{id}', [
			'as' => 'usuario.delete',
			'uses' => 'UsuarioController@destroy'
			]);
		
		Route::resource("tickets", "TicketsController");
		Route::get('tickets/delete/{id}', [
		    'as' => 'tickets.delete',
		    'uses' => 'TicketsController@destroy',
		]);

		Route::resource("categoriasTickets", "CategoriasTicketsController");
		Route::get('categoriasTickets/delete/{id}', [
		    'as' => 'categoriasTickets.delete',
		    'uses' => 'CategoriasTicketsController@destroy',
		]);
	});

});





