
<!-- Header Nav End -->
<div class="header-menu header-menu-style-3 bg-blue  d-lg-block d-none ptb-13px">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header-menu-vertical">
                    <h4 class="menu-title">Rubros Categorias </h4>
                    <ul class="menu-content display-none">
                        @foreach($categorias as $cate)
                            <li class="menu-item">
                                <a href="#" data-rub-id="{{$cate['rub_id']}}">{{$cate['nombre']}}<i class="ion-ios-arrow-right"></i></a>
                                <ul class="sub-menu flex-wrap">
                                    @foreach($cate['padres'] as $padre)
                                        <li>
                                            <a href="#" data-pad-cat-id="{{$padre['cat_id']}}">
                                                <span> <strong> {{$padre['nombre']}}</strong></span>
                                            </a>
                                            <ul class="submenu-item">
                                                @foreach($padre['hijos'] as $hijo)
                                                    <li><a href="{{url('producto/categorias/'.$hijo['cat_id'].'/lista')}}" target="_blank">{{$hijo['nombre']}}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                                <!-- sub menu -->
                            </li>
                        @endforeach
                    </ul>
                    <!-- menu content -->
                </div>
                <!-- header menu vertical -->
            </div>
            <div class="col-lg-7">
                <div class="header-right-element d-flex">
                    <div class="search-element media-body">
                        <form class="d-flex" action="{{url('producto/buscar')}}" method="get">
                            <div class="search-category">
                                <select name="cat_id" id="cat_id_web">
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
                            <input type="text" name="search" id="search_web" placeholder="Ingrese su busqueda... " />
                            <button>Buscar</button>
                        </form>
                    </div>
                </div>
            </div>
            <!--Cart info Start -->
            <div class="col-lg-3 text-right">
                <div class="header-tools">
                    <div class="cart-info align-self-center">
                        {{--<a href="#offcanvas-wishlist" class="heart offcanvas-toggle"><i class="lnr lnr-heart"></i><span>Wishlist</span></a>--}}
                        <a href="{{url('mensajes')}}" class="mensajes heart"><i class="lnr lnr-alarm"></i><span>Mensajes</span></a>
                        <a href="{{url('carrito/ver')}}" class="carrito bag"><i class="lnr lnr-cart"></i><span>Mi Carrito</span></a>
                    </div>
                </div>
            </div>
            <!--Cart info End -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</div>
<!-- header menu -->
