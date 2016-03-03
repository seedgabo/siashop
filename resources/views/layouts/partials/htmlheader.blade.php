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
    <link href="{{ asset('/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <!-- Estilos personales -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- plugins -->
    <link href="{{ asset('/css/jquerytoast.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/lightbox.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('/css/jquery.datetimepicker.css')}}">
    <script src="{{ asset('/js/jquery.datetimepicker.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.datetimepicker.full.min.js') }}"></script>
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
    <script>
       $(function () {
            $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
            jQuery('.datetimepicker').datetimepicker({format:'Y-m-d H:i:s'});
            $(".chosen").chosen({disable_search_threshold: 10});
        });
   </script>
</head>
