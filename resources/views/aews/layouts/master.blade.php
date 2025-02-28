<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="default" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="enable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | SRDI in CL - DA-PhilRice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico')}}">
    @include('aews.layouts.head-css')
</head>

@section('body')
    @include('aews.layouts.body')
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('aews.layouts.topbar')
        @include('aews.layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('aews.layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    @include('aews.layouts.customizer')

    <!-- JAVASCRIPT -->
    @include('aews.layouts.vendor-scripts')
</body>

</html>
