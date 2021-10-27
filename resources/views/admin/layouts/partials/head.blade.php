<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | @yield('page_title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('public/assets/admin/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
{{--    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">--}}
<!-- DataTables -->
    <link rel="stylesheet" href="{{asset('public/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('public/assets/admin/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    @yield('styles')
    <style>
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #dc3545;
        }
        .page-link{
            color: #ffffff !important;
            background-color:#dc3545 ;
        }
        .page-item.active .page-link{
            background-color: black;
            border-color: black;
        }
        .page-item.disabled .page-link{
            color:white;
            background-color:  #dc3545;;
        }
        .page-link:hover{
            background-color:#dc3545 ;

        }
    </style>
</head>

<style>
    .close-icon {
        position: absolute;
        right: 20px;
        top: 6px;
        color: #000;
        cursor: pointer;
    }

    .close-icon h5 {
        color: #dc3545;
        font-size: 18px;
    }

    .cont-close {
        position: absolute;
        right: 10px;
        top: 1px;
        font-size: 20px;
        color: #000;
        cursor: pointer;


    }
    .remov_section{
        color: #dc3545;

    }


    .new-custom-text-pic ul {
        display: flex;
        justify-content: center;
        align-items: center;
        list-style: none;
    }

    .new-custom-text-pic ul li {
        padding: 20px 20px 0;
    }

    .new-custom-text-pic ul li p {
        font-size: 15px;
        margin: 6px 0 0;
        color: #000;
        font-weight: 500; text-align: center;
    }

</style>
