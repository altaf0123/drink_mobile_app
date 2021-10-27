<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.partials.head')


<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
@include('admin.layouts.partials.navbar')

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
@include('admin.layouts.partials.sidebar_nav')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('page_title')</h1>
                    </div>
                </div>
                @if(session()->has('success'))
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 class="alert alert-success alert-dismissible">{{session()->get('success')}}</h3>
                        </div>
                    </div>
                @elseif(session()->has('error'))
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 class="alert alert-danger alert-dismissible">{{session()->get('error')}}</h3>
                        </div>
                    </div>
                @endif
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@include('admin.layouts.partials.footer')

</div>
<!-- ./wrapper -->
@include('admin.layouts.partials.footer_scripts')

</body>
