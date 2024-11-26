<!-- Header Nav Start -->
<!-- Header para movil-->
<div class="header-nav d-lg-none">
    <div class="container">
        <div class="header-nav-wrapper d-md-flex d-sm-flex d-xl-flex d-lg-flex justify-content-between">
            <div class="header-static-nav">

            </div>
            <div class="header-menu-nav">
                <ul class="menu-nav">
                    <li class="pr-0">
                        <div class="dropdown">
                            <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @guest
                                    Mi Cuenta
                                @else
                                    {{Auth::user()->name}}
                                @endguest
                                <i class="ion-ios-arrow-down"></i>
                            </button>

                            <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton">
                                @guest
                                    <li><a href="{{ route('login') }}">Ingresar</a></li>
                                    @if (Route::has('register'))
                                        <li><a href="{{ route('register') }}">Registrarse</a></li>
                                    @endif
                                @else
                                    <li><a href="{{url('usuario/miperfil')}}">Mi perfil</a></li>
                                    @guest
                                    @else
                                        @if(Auth::user()->correo_validado == 0)
                                            <li><a href="#"
                                                   onclick="event.preventDefault();enviarCorreoValidacion();">Reenviar Link de Verificación de Correo</a>
                                            </li>
                                        @endif
                                    @endguest
                                    <li><a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Salir</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                @endguest
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Header para movil end-->
<!-- Header Nav End -->
<div class="header-top header-style-3 bg-white sticky-nav ptb-10px d-lg-block d-none">
    <div class="container">
        <div class="row">
            <div class="col-md-2 d-flex">
                <div class="logo align-self-center">
                    <a href="{{url('/')}}"><img class="img-responsive" src="{{asset('storage/uploads/'.$datospagina->imagen_icono)}}" alt="logo.jpg" /></a>
                </div>
            </div>
            <div class="col-md-6 align-self-center header-menu-3">
                <div class="header-horizontal-menu">
                    <ul class="menu-content">
                        <li class="active menu-dropdown">
                            <a href="{{url('feriavirtual/lista')}}">Ferias Virtuales</a>
                        </li>
                        @guest

                        @else
                            <li class="active menu-dropdown">
                                <a href="{{url('venta/miscompras')}}">Mis Compras</a>
                            </li>
                            @if(Auth::user()->rol == 2)
                                <li class="menu-dropdown">
                                    <a href="#">Mi Tienda <i class="ion-ios-arrow-down"></i></a>
                                    <ul class="main-sub-menu">
                                        <li><a href="{{url('productor/createeditproductor/'.Auth::user()->id)}}">Mis Datos</a></li>
                                        <li><a href="{{url('delivery/'.Auth::user()->id)}}">Mis Deliveries</a></li>
                                        <li><a href="{{url('producto/'.Auth::user()->id).'/lista'}}">Mis Productos</a></li>
                                        <li><a href="{{url('venta/'.Auth::user()->id).'/misventas'}}">Mis Ventas</a></li>
                                        <li><a href="{{url('feriaproducto/misferias/'.Auth::user()->id).'/lista'}}">Mis Ferias</a></li>
                                    </ul>
                                </li>
                            @elseif(Auth::user()->rol == 3)
                                <li class="menu-dropdown">
                                    <a href="#">Administración<i class="ion-ios-arrow-down"></i></a>
                                    <ul class="main-sub-menu">
                                        <li class="menu-dropdown position-static">
                                            <a href="#">Gestión página<i class="ion-ios-arrow-right"></i></a>
                                            <ul class="main-sub-menu main-sub-menu-2">
                                                <li><a href="{{url('institucion/createedit')}}">Datos de la Página</a></li>
                                                <li><a href="{{url('administracion/usuarios')}}">Usuarios</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-dropdown position-static">
                                            <a href="#">Tipologías<i class="ion-ios-arrow-right"></i></a>
                                            <ul class="main-sub-menu main-sub-menu-2">
                                                <li><a href="{{url('rubro')}}">Rubros y Categorias</a></li>
                                                <li><a href="{{url('asociacion')}}">Asociaciones</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-dropdown position-static">
                                            <a href="#">Productores<i class="ion-ios-arrow-right"></i></a>
                                            <ul class="main-sub-menu main-sub-menu-2">
                                                <li><a href="{{url('administracion/productores')}}">Productores</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-dropdown position-static">
                                            <a href="#">Ferias Virtuales<i class="ion-ios-arrow-right"></i></a>
                                            <ul class="main-sub-menu main-sub-menu-2">
                                                <li><a href="{{url('feriavirtual')}}">Ferias Virtuales</a></li>
                                                <li><a href="{{url('invitacionproductor')}}">Crear invitación</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-dropdown position-static">
                                            <a href="#">Seguimiento<i class="ion-ios-arrow-right"></i></a>
                                            <ul class="main-sub-menu main-sub-menu-2">
                                                <li><a href="{{url('venta/ventassistema')}}">Ventas</a></li>
                                                <li><a href="{{url('denuncia')}}">Denuncias</a></li>
                                                <li><a href="{{url('invitacionproductor/listainvitacion')}}">Lista invitaciones</a></li>
                                                <li><a href="{{url('publicidad')}}">Publicidades</a></li>
                                                <li><a href="{{url('enviarcorreomasivo')}}">Correos Masivos</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-dropdown position-static">
                                            <a href="#">Log<i class="ion-ios-arrow-right"></i></a>
                                            <ul class="main-sub-menu main-sub-menu-2">
                                                <li><a href="{{url('logsistema')}}">Logs Sistema</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-dropdown position-static">
                                            <a href="#">Backups<i class="ion-ios-arrow-right"></i></a>
                                            <ul class="main-sub-menu main-sub-menu-2">
                                                <li><a href="{{url('backups')}}">Backups Sistema</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            @else
                            @endif
                        @endguest
                    </ul>
                </div>
            </div>
            <div class="col-md-4 text-right align-self-center header-nav ">
                <div class="header-menu-nav">
                    <ul class="menu-nav">
                        <li class="pr-0">
                            <div class="dropdown">
                                <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @guest
                                        Mi Cuenta
                                    @else
                                        {{Auth::user()->name}}
                                    @endguest
                                    <i class="ion-ios-arrow-down"></i>
                                </button>

                                <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton">
                                    @guest
                                        <li><a href="{{ route('login') }}">Ingresar</a></li>
                                        @if (Route::has('register'))
                                            <li><a href="{{ route('register') }}">Registrarse</a></li>
                                        @endif
                                    @else
                                        <li><a href="{{url('usuario/miperfil')}}">Mi perfil</a></li>
                                        @guest
                                        @else
                                            @if(Auth::user()->correo_validado == 0)
                                                <li><a href="#"
                                                       onclick="event.preventDefault(); enviarCorreoValidacion();">Reenviar Link de Verificación de Correo</a>
                                                </li>
                                            @endif
                                        @endguest
                                        <li><a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Salir</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    @endguest
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
