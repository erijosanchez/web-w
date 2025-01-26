<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="{{ isActiveRoute('admin.dashboard') }}">
                    <a href="{{ route('admin.dashboard') }}"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                </li>
                <li class="menu-title">Web Configuracion</li><!-- /.menu-title -->
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <i class="menu-icon fa fa-globe"></i>Páginas</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-puzzle-piece"></i><a href="ui-buttons.html">Buttons</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Banners</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="menu-icon fa fa-th"></i><a href="forms-basic.html">Basic Form</a></li>
                        <li><i class="menu-icon fa fa-th"></i><a href="forms-advanced.html">Advanced Form</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Sliders</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="menu-icon fa fa-th"></i><a href="forms-basic.html">Basic Form</a></li>
                        <li><i class="menu-icon fa fa-th"></i><a href="forms-advanced.html">Advanced Form</a></li>
                    </ul>
                </li>

                <li class="menu-title">Productos</li><!-- /.menu-title -->

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Icons</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="menu-icon fa fa-fort-awesome"></i><a href="font-fontawesome.html">Font Awesome</a>
                        </li>
                        <li><i class="menu-icon ti-themify-logo"></i><a href="font-themify.html">Themefy Icons</a></li>
                    </ul>
                </li>
                <li>
                    <a href="widgets.html"> <i class="menu-icon ti-email"></i>Widgets </a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <i class="menu-icon fa fa-bar-chart"></i>Charts</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="menu-icon fa fa-line-chart"></i><a href="charts-chartjs.html">Chart JS</a></li>
                    </ul>
                </li>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <i class="menu-icon fa fa-area-chart"></i>Maps</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="menu-icon fa fa-map-o"></i><a href="maps-gmap.html">Google Maps</a></li>
                        <li><i class="menu-icon fa fa-street-view"></i><a href="maps-vector.html">Vector Maps</a></li>
                    </ul>
                </li>

                <!-- SECCION DONDE SE MOSTRARÁ EL LISTADO DE TODO EL PERSONAL A CARGO -->
                @if (auth()->check())
                    <li class="menu-title ">Personal</li><!-- /.menu-title -->
                    <li
                        class="menu-item-has-children dropdown {{ isActiveRoute('admin.createAdmin') }} {{ isActiveRoute('admin.superadmins') }} 
                        {{ isActiveRoute('admin.admins') }} {{ isActiveRoute('admin.supervisores') }}">

                        @if (auth()->user()->role_id === 4)
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"> <i class="menu-icon fa fa-group"></i>Administradores</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="menu-icon ti-marker-alt"></i><a href="#">Crear
                                        Roles</a></li>
                                <li><i class="menu-icon ti-marker-alt"></i><a href="#">Crear
                                        Permisos</a></li>
                                <li><i class="menu-icon ti-hummer"></i><a href="{{ route('admin.createAdmin') }}">Crear
                                        Administrador</a></li>

                                <li><i class="menu-icon ti-crown"></i><a href="{{ route('admin.superadmins') }}">Super
                                        Admins</a>
                                </li>
                                <li><i class="menu-icon ti-stamp"></i><a href="{{ route('admin.admins') }}">Admins</a>
                                </li>
                                <li><i class="menu-icon ti-write"></i><a
                                        href="{{ route('admin.supervisores') }}">Supervicion y Reportes</a></li>
                            </ul>
                        @elseif(auth()->user()->role_id === 5)
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"> <i class="menu-icon fa fa-group"></i>Administradores</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="menu-icon ti-stamp"></i><a href="{{ route('admin.admins') }}">Admins</a>
                                </li>
                                <li><i class="menu-icon ti-write"></i><a
                                        href="{{ route('admin.supervisores') }}">Supervicion y reportes</a></li>
                            </ul>
                        @endif

                    </li>
                @endif
                <!-- //////////////////////////////////////////////////////////////////////////////////// -->

                <li class="menu-title">Marketing</li><!-- /.menu-title -->
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <i class="menu-icon fa fa-glass"></i>Pages</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="menu-icon fa fa-sign-in"></i><a href="page-login.html">Login</a></li>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>