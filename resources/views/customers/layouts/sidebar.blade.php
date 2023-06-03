<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true"
     data-img="theme-assets/images/backgrounds/02.jpg">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="index.html"><img class="brand-logo"
                                                                                        alt="Chameleon admin logo"
                                                                                        src="{{ asset('customers/theme-assets/images/logo/logo.png') }}"/>
                    <h3 class="brand-text">Chameleon</h3></a></li>
            <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
    </div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ route('home') }}"><i
                        class="ft-home"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
            </li>
            <li class="{{ request()->is('reports') ? 'active' : '' }}"><a href="{{ route('reports') }}"><i
                        class="ft-bar-chart"></i><span class="menu-title" data-i18n="">Financial Reports</span></a>
            </li>
            <li class="{{ request()->is('my-assets') ? 'active' : '' }}"><a href="{{ route('assets') }}"><i
                        class="ft-box"></i><span class="menu-title" data-i18n="">My Assets</span></a>
            </li>
            <li class="{{ request()->is('my-locations') ? 'active' : '' }}"><a href="{{ route('locations') }}"><i
                        class="ft-map"></i><span class="menu-title" data-i18n="">My Locations</span></a>
            </li>
            <li class="{{ request()->is('my-documents') ? 'active' : '' }}"><a href="{{ route('docs') }}"><i
                        class="ft-file"></i><span class="menu-title" data-i18n="">My Documents</span></a>
            </li>
            <li class="{{ request()->is('my-orders') ? 'active' : '' }}"><a href="{{ route('orders') }}"><i
                        class="ft-box"></i><span class="menu-title" data-i18n="">My Orders</span></a>
            </li>
{{--            <li class="{{ request()->is('my-documents') ? 'active' : '' }}"><a href="{{ route('docs') }}"><i--}}
{{--                        class="ft-file"></i><span class="menu-title" data-i18n="">My Documents</span></a>--}}
{{--            </li>--}}
            <li><a href="{{ route('logout') }}"><i class="ft-power"></i><span class="menu-title"
                                                                              data-i18n="">Logout</span></a>
            </li>
        </ul>
    </div>
</div>
