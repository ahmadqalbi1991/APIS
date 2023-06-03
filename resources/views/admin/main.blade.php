<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.head')
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    @include('admin.layouts.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('admin.layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
   @yield('content')
    <!-- /.content-wrapper -->

    @include('admin.layouts.footer')

</div>
<!-- ./wrapper -->

@include('admin.layouts.scripts')
</body>
</html>
