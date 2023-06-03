<!doctype html>
<html class="no-js" lang="">

<head>
    @include('layout.head')
</head>

<body>
<!-- Start Header Top Area -->
@include('layout.header')
<!-- End Header Top Area -->
<!-- Main Menu area start-->
<div class="main-menu-area mg-tb-40">
    @include('layout.main-menu')
</div>
<!-- Main Menu area End-->
<!-- Start Status area -->
@yield('content')
<!-- End Status area-->

@include('layout.scripts')

</body>

</html>
