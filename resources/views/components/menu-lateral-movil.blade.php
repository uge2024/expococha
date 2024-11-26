<!-- OffCanvas Search Start -->
<div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
    <div class="inner customScroll">
        <div class="head">

            @guest
                <span class="title">&nbsp;</span>
            @else
                <span class="title">{{Auth::user()->email}}</span>
            @endguest

            <button class="offcanvas-close">×</button>
        </div>
        <div class="offcanvas-menu-search-form">
            {{--<form action="#">
                <input type="text" placeholder="Search...">
                <button><i class="lnr lnr-magnifier"></i></button>
            </form>--}}
        </div>
        <div class="offcanvas-menu">
            <ul>
                <li>
                    <a href="{{url('feriavirtual/lista')}}"><span class="menu-text">Ferias Virtuales</span></a>
                </li>

                @guest

                @else
                    <li>
                        <a href="{{url('venta/miscompras')}}"><span class="menu-text">Mis Compras</span></a>
                    </li>
                    @if(Auth::user()->rol == 2)
                        <li><a href="#"><span class="menu-text">Mi Tienda</span></a>
                            <ul class="sub-menu">
                                <li><a href="{{url('productor/createeditproductor/'.Auth::user()->id)}}"><span class="menu-text">Mis Datos</span></a></li>
                                <li><a href="{{url('delivery/'.Auth::user()->id)}}"><span class="menu-text">Mis Deliveries</span></a></li>
                                <li><a href="{{url('producto/'.Auth::user()->id).'/lista'}}"><span class="menu-text">Mis Productos</span></a></li>
                                <li><a href="{{url('venta/'.Auth::user()->id).'/misventas'}}"><span class="menu-text">Mis Ventas</span></a></li>
                                <li><a href="{{url('feriaproducto/misferias/'.Auth::user()->id).'/lista'}}"><span class="menu-text">Mis Ferias</span></a></li>
                            </ul>
                        </li>
                    @elseif(Auth::user()->rol == 3)
                        <li><a href="#"><span class="menu-text">Administración</span></a>
                            <ul class="sub-menu">
                                <li><a href="#"><span class="menu-text">Gestión página</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="{{url('institucion/createedit')}}">Datos de la Página</a></li>
                                        <li><a href="{{url('administracion/usuarios')}}">Usuarios</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><span class="menu-text">Tipologías</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="{{url('rubro')}}">Rubros y Categorias</a></li>
                                        <li><a href="{{url('asociacion')}}">Asociaciones</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><span class="menu-text">Productores</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="{{url('administracion/productores')}}">Productores</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><span class="menu-text">Ferias Virtuales</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="{{url('feriavirtual')}}">Ferias Virtuales</a></li>
                                        <li><a href="{{url('invitacionproductor')}}">Crear invitación</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><span class="menu-text">Seguimiento</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="{{url('venta/ventassistema')}}">Ventas</a></li>
                                        <li><a href="{{url('denuncia')}}">Denuncias</a></li>
                                        <li><a href="{{url('invitacionproductor/listainvitacion')}}">Lista invitaciones</a></li>
                                        <li><a href="{{url('publicidad')}}">Publicidades</a></li>
                                        <li><a href="{{url('enviarcorreomasivo')}}">Correos Masivos</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><span class="menu-text">Log</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="{{url('logsistema')}}">Logs Sistema</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><span class="menu-text">Backups</span></a>
                                    <ul class="sub-menu">
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
        <!-- OffCanvas Menu End -->
        <div class="offcanvas-social mt-30px">
            <ul>
                @isset($datospagina->link_facebook)
                    <li>
                        <a href="{{$datospagina->link_facebook}}" target="_blank"><i class="ion-social-facebook"></i></a>
                    </li>
                @endisset
                @isset($datospagina->link_twiter)
                    <li>
                        <a href="{{$datospagina->link_twiter}}" target="_blank"><i class="ion-social-twitter"></i></a>
                    </li>
                @endisset
                @isset($datospagina->link_instagram)
                    <li>
                        <a href="{{$datospagina->link_instagram}}" target="_blank"><i class="ion-social-instagram"></i></a>
                    </li>
                @endisset
                @isset($datospagina->link_youtube)
                    <li>
                        <a href="{{$datospagina->link_youtube}}" target="_blank"><i class="ion-social-youtube"></i></a>
                    </li>
                @endisset
            </ul>
        </div>
    </div>
</div>
<!-- OffCanvas Search End -->
