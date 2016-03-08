<head>
    <title> Acceso a Cartera Siasoft </title>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    
    <meta name="csrf-token" content="<?php echo csrf_token() ?>"/>
    
    <link rel="shortcut icon" type="image/png" href="{{asset('img/favicon.png')}}"/>

    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('/css/skins/skin-blue.css') }}" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- plugins -->
    <script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <!-- Jquery Toast -->
    <link href="{{ asset('/css/jquerytoast.min.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- Lightbox -->
    <link href="{{ asset('/css/lightbox.min.css') }}" rel="stylesheet" type="text/css" />
    
    
    <!-- DateTimePicker -->
    <link rel="stylesheet" type="text/css" href="{{asset('/css/jquery.datetimepicker.css')}}">
    <script src="{{ asset('/js/jquery.datetimepicker.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.datetimepicker.full.min.js') }}"></script>
    
    <!-- Chosen -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
    
    <!-- Ckeditor -->
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    
    <!-- Datatable -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css">
    <script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
    <script>
          
       $(document).ready(function(){
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            jQuery.datetimepicker.setLocale('es');
            jQuery('.datetimepicker').datetimepicker({format:'Y-m-d H:i:s',mask:true});
            jQuery('.datetimepicker').val("{{Carbon\Carbon::now()->format('Y-m-d H:i:s')}}");

            $(".chosen").chosen();

            if($('#textarea').length >0)
                CKEDITOR.replace( 'textarea' );

            $('table').DataTable({
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
            $('table').addClass("table-dondensed")
       });
   </script>
</head>
