<!-- Mobile Header Section Start -->
<div class="mobile-header d-lg-none sticky-nav bg-white ptb-20px">
    <div class="container">
        <div class="row align-items-center">

            <!-- Header Logo Start -->
            <div class="col">
                <div class="header-logo">
                    <a href="{{url('/')}}"><img class="img-responsive" src="{{asset('storage/uploads/'.$datospagina->imagen_icono)}}" alt="logo.jpg" /></a>
                </div>
            </div>
            <!-- Header Logo End -->

            <!-- Header Tools Start -->
            <div class="col-auto">
                <div class="header-tools justify-content-end">
                    <div class="cart-info d-flex align-self-center">
                        {{--<a href="#offcanvas-wishlist" class="heart offcanvas-toggle"><i class="lnr lnr-heart"></i><span>Wishlist</span></a>--}}
                        @if($nomostrarheaderbuscar == 0)
                            <a href="{{url('mensajes')}}" class="mensajes heart"><i class="lnr lnr-alarm"></i><span>Mensajes</span></a>
                            <a href="{{url('carrito/ver')}}" class="carrito bag"><i class="lnr lnr-cart"></i><span>Mi Carrito</span></a>
                        @endif
                    </div>
                    <div class="mobile-menu-toggle">
                        <a href="#offcanvas-mobile-menu" class="offcanvas-toggle">
                            <svg viewBox="0 0 800 600">
                                <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                                <path d="M300,320 L540,320" id="middle"></path>
                                <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Header Tools End -->

        </div>
    </div>
</div>

@if($nomostrarheaderbuscar == 0)
    <!-- Search Category Start -->
    <div class="mobile-search-area d-lg-none mb-15px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-element media-body">
                        <form class="d-flex" action="{{url('producto/buscar')}}" method="get">
                            <div class="search-category">
                                <select name="cat_id" id="cat_id_movil">
                                    <option value="0">Todos</option>
                                    @foreach($categorias as $cate)
                                        {{--<option value="{{$cate['rub_id']}}">{{$cate['nombre']}}</option>--}}
                                        <optgroup label="{{$cate['nombre']}}">
                                            @foreach($cate['padres'] as $padre)
                                                {{--<option value="{{$padre['cat_id']}}">- - {{$padre['nombre']}}</option>--}}
                                                <optgroup label="- - {{$padre['nombre']}}">
                                                    @foreach($padre['hijos'] as $hijo)
                                                        <option value="{{$hijo['cat_id']}}">- - - - {{$hijo['nombre']}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" name="search" id="search_movil" placeholder="Ingrese su busqueda... " />
                            <button><i class="lnr lnr-magnifier"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Category End -->
    <div class="mobile-category-nav d-lg-none mb-15px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <!--=======  category menu  =======-->
                    <div class="hero-side-category">
                        <!-- Category Toggle Wrap -->
                        <div class="category-toggle-wrap">
                            <!-- Category Toggle -->
                            <button class="category-toggle"><i class="fa fa-bars"></i> Rubros Categorias</button>
                        </div>

                        <!-- Category Menu -->
                        <nav class="category-menu">
                            <ul>
                                @php
                                    $i1 = 1;
                                @endphp
                                @foreach($categorias as $cate)
                                    <li class="menu-item-has-children">
                                        <a href="#" data-rub-id="{{$cate['rub_id']}}" onclick="event.preventDefault();cambiarEstadoMenuMovil('#ul{{$i1}}');">{{$cate['nombre']}} <i class="ion-ios-arrow-down"></i></a>
                                        <!-- category submenu -->
                                        <ul id="ul{{$i1}}" class="category-mega-menu">
                                            @php
                                                $i2 = 1;
                                            @endphp
                                            @foreach($cate['padres'] as $padre)
                                                <li class="menu-item-has-children">
                                                    <a href="#" data-cat-padre-id="{{$padre['cat_id']}}" onclick="event.preventDefault();cambiarEstadoMenuMovil('#ul{{$i1}}-{{$i2}}');">{{$padre['nombre']}} <i class="ion-ios-arrow-down"></i></a>
                                                    <!-- category submenu -->
                                                    <ul id="ul{{$i1}}-{{$i2}}" class="category-mega-menu">
                                                        @foreach($padre['hijos'] as $hijo)
                                                            <li><a target="_blank" href="{{url('producto/categorias/'.$hijo['cat_id'].'/lista')}}">{{$hijo['nombre']}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                @php
                                                    $i2++;
                                                @endphp
                                            @endforeach
                                        </ul>
                                    </li>
                                    @php
                                        $i1++;
                                    @endphp
                                @endforeach

                            </ul>
                        </nav>
                    </div>

                    <!--=======  End of category menu =======-->
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Header Section End -->
@endif
