<!-- Footer Area Start -->
<div class="footer-area" style="border-top: 1px solid #e5e5e5;">
    <div class="footer-container">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-md-30px mb-lm-30px">
                        <div class="single-wedge">
                            <div class="footer-logo">
                                <a href="{{url('/')}}"><img class="img-responsive" src="{{asset('storage/uploads/'.$datospagina->imagen_icono)}}" alt="logo.jpg" /></a>
                            </div>
                            <p class="text-infor">{{$datospagina->nombre}}</p>
                            <p class="text-infor">{{$datospagina->descripcion}}</p>
                            <div class="need_help">

                            </div>

                            <div class="footer-logo">
                                <a href="https://play.google.com/store" target="_blank">
                                    <div class="col-md-12 row">
                                        <div class="col-md-4">
                                            <img class="img-responsive" src="{{asset('images/imageniconoaplicacion.jpeg')}}" width="80" height="80" alt="logo.jpg" />
                                        </div>
                                        <div class="col-md-8">
                                            <br>
                                            <br>
                                            <span>Descargar nuestra App Desde PlayStore</span>
                                        </div>
                                    </div>
<!--                                    <img class="img-responsive" src="{{asset('images/imageniconoaplicacion.jpeg')}}" width="80" height="80" alt="logo.jpg" />
                                    <span>Descargar nuestra App Desde PlayStore</span>-->
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 col-sm-6 mb-md-30px mb-lm-30px">
                        <div class="single-wedge">
                            <h4 class="footer-herading">Información</h4>
                            <div class="footer-links">
                                <ul>
                                    <li><a href="{{url('acerca-de-nosotros')}}">Acerca de Nosotros</a></li>
                                    <li><a id="linkrealizardenuncia" href="{{'denuncia/midenuncia'}}">Realizar denuncia</a></li>
                                    <li><a href="{{url('politica-privacidad')}}">Política de Privacidad</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 col-sm-6 mb-sm-30px mb-lm-30px">

                    </div>
                    <div class="col-md-6 col-lg-4 ">
                        <div class="single-wedge">
                            <div class="need_help">
                                <p class="add"><span class="address">Dirección:</span> {{$datospagina->direccion}}</p>
                                <p class="phone"><span class="call us">Celular:</span> <a href="tel:{{$datospagina->celular}}">{{$datospagina->celular}}</a></p>
                                <p class="phone"><span class="call us">Whatsapp:</span> {{$datospagina->celular_wp}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">

                    </div>
                    <div class="col-md-6">
                        <div class="footer-social-icon d-flex">
                            <div class="heading-info">Siguenos por:</div>
                            <div class="social-icon">
                                <ul>
                                    @isset($datospagina->link_facebook)
                                        <li class="facebook">
                                            <a href="{{$datospagina->link_facebook}}" target="_blank"><i class="ion-social-facebook"></i></a>
                                        </li>
                                    @endisset
                                    @isset($datospagina->link_twiter)
                                        <li class="twitter">
                                            <a href="{{$datospagina->link_twiter}}" target="_blank"><i class="ion-social-twitter"></i></a>
                                        </li>
                                    @endisset
                                    @isset($datospagina->link_instagram)
                                        <li class="instagram">
                                            <a href="{{$datospagina->link_instagram}}" target="_blank"><i class="ion-social-instagram"></i></a>
                                        </li>
                                    @endisset
                                    @isset($datospagina->link_youtube)
                                        <li class="youtube">
                                            <a href="{{$datospagina->link_youtube}}" target="_blank"><i class="ion-social-youtube"></i></a>
                                        </li>
                                    @endisset
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-tags">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 align-content-center">
                        <div class="tag-content" style="float: none;">
                            <ul>
                                @foreach($rubros as $key=>$rubro)
                                    <li><a target="_blank" href="{{url('producto/rubros/'.$rubro->rub_id.'/lista')}}">{{$rubro->nombre}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <p class="copy-text">Copyright © <a target="_blank" href="https://www.serconsig.com"> Serconsig</a>. Todos los derechos reservados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer Area End -->
