<head>
    <title> Siasoft Web </title>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <meta name="csrf-token" content="<?php echo csrf_token() ?>"/>

    <link rel="shortcut icon" type="image/png" href="{{asset('img/favicon.png')}}"/>

    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link rel="stylesheet" href="https://bootswatch.com/readable/bootstrap.min.css" media="screen" title="no title" charset="utf-8"> --}}
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('/css/skins/skin-blue.css') }}" rel="stylesheet" type="text/css" />

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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/bs/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.11,b-1.1.2,b-colvis-1.1.2,b-html5-1.1.2,b-print-1.1.2,cr-1.3.1/datatables.min.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/t/bs/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.11,b-1.1.2,b-colvis-1.1.2,b-html5-1.1.2,b-print-1.1.2,cr-1.3.1/datatables.min.js"></script>

    <script src="{{asset('js/qrcode.min.js')}}"></script>

    @include('layouts.partials.initialscript')

</head>
