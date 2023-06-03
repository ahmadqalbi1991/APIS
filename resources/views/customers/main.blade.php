<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

@include('customers.layouts.head')

<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">

@include('customers.layouts.header')

@include('customers.layouts.sidebar')

@yield('content')

@include('customers.layouts.footer')

@include('customers.layouts.scripts')

</body>
</html>
