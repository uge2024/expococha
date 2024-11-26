@extends('layouts.layout_main')

@section('header_styles')
    <link rel="stylesheet" href="{{asset('css/ol.css')}}" type="text/css">
    <style type="text/css">
        .estrellas-productor{
            height: 50px;
            font-size: 40px;
        }
        .colorear-estrella{
            color: #fdd835 !important;
        }
        .sincolor-estrella{
            color: #9d9c9c !important;
        }
        .div-comentarios{
            max-height: 500px;
            overflow-y: scroll;
        }
        .map {
            height: 400px;
            width: 100%;
        }
        .div-titulo-redes {
            font-size: 18px;
            color: #272727;
            margin: 0 20px 0 0;
            text-transform: capitalize;
            display: inline-block;
            font-weight: 600;
            vertical-align: bottom;
            align-self: center;
        }
        .clasefacebook{
            line-height: 34px;
        }
        .clasefacebook > a{
            display: inline-block;
            vertical-align: middle;
            color: #fff;
            font-size: 16px;
            width: 34px;
            height: 34px;
            background: #3b579d;
            border-radius: 100%;
            text-align: center;
        }
        .clasetwitter{
            line-height: 34px;
        }
        .clasetwitter > a{
            background: #1da1f2;
            display: inline-block;
            vertical-align: middle;
            color: #fff;
            font-size: 16px;
            width: 34px;
            height: 34px;
            border-radius: 100%;
            text-align: center;
        }
        .clasegoogle{
            line-height: 34px;
        }
        .clasegoogle > a{
            background: #cc3333;
            display: inline-block;
            vertical-align: middle;
            color: #fff;
            font-size: 16px;
            width: 34px;
            height: 34px;
            border-radius: 100%;
            text-align: center;
        }
        .claseyoutube{
            line-height: 34px;
        }
        .claseyoutube > a{
            background: #d32a2a;
            display: inline-block;
            vertical-align: middle;
            color: #fff;
            font-size: 16px;
            width: 34px;
            height: 34px;
            border-radius: 100%;
            text-align: center;
        }
        .claseinstagram{
            line-height: 34px;
        }
        .claseinstagram > a{
            background: #a0369c;
            display: inline-block;
            vertical-align: middle;
            color: #fff;
            font-size: 16px;
            width: 34px;
            height: 34px;
            border-radius: 100%;
            text-align: center;
        }
        .clasewhatsapp{
            line-height: 34px;
        }
        .clasewhatsapp > a{
            background: #50ca5e;
            display: inline-block;
            vertical-align: middle;
            color: #fff;
            font-size: 16px;
            width: 34px;
            height: 34px;
            border-radius: 100%;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{url('/')}}">Inicio</a></li>
                            <li>Productor: Mi Tienda</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <div class="container">
        <!-- Slider Start -->
        <div class="slider-area slider-dots-style-3">
            <div class="hero-slider-wrapper">
                <!-- Single Slider  -->
                <div class="single-slide slider-height-3 bg-img d-flex" data-bg-image="{{asset('images/slider-image/sample-7.jpg')}}">
                    <div class="container align-self-center">
                        <div class="slider-content-1 slider-animated-1 text-left">
                            <h1 class="animated color-black">
                                MI TIENDA
                                <br />
                                SOMO EXPERTOS EN MIS PRUDCTOS
                            </h1>
                            <p class="animated color-gray">Fabricamos todo tipo de productos en madera.</p>
                            {{--<a href="shop-4-column.html" class="shop-btn animated">SHOP NOW</a>--}}
                        </div>
                    </div>
                </div>
                <!-- Single Slider  -->
                <div class="single-slide slider-height-3 bg-img d-flex" data-bg-image="{{asset('images/slider-image/sample-7.jpg')}}">
                    <div class="container align-self-center">
                        <div class="slider-content-1 slider-animated-1 text-left">
                            <h1 class="animated color-black">
                                MI TIENDA
                                <br />
                                SOMO EXPERTOS EN MIS PRUDCTOS
                            </h1>
                            <p class="animated color-gray">Fabricamos todo tipo de productos en madera.</p>
                            {{--<a href="shop-4-column.html" class="shop-btn animated">SHOP NOW</a>--}}
                        </div>
                    </div>
                </div>
                <!-- Single Slider  -->
                <div class="single-slide slider-height-3 bg-img d-flex" data-bg-image="{{asset('images/slider-image/sample-7.jpg')}}">
                    <div class="container align-self-center">
                        <div class="slider-content-1 slider-animated-1 text-left">
                            <h1 class="animated color-black">
                                MI TIENDA
                                <br />
                                SOMO EXPERTOS EN MIS PRUDCTOS
                            </h1>
                            <p class="animated color-gray">Fabricamos todo tipo de productos en madera.</p>
                            {{--<a href="shop-4-column.html" class="shop-btn animated">SHOP NOW</a>--}}
                        </div>
                    </div>
                </div>
                <!-- Single Slider  -->
                <div class="single-slide slider-height-3 bg-img d-flex" data-bg-image="{{asset('images/slider-image/sample-7.jpg')}}">
                    <div class="container align-self-center">
                        <div class="slider-content-1 slider-animated-1 text-left">
                            <h1 class="animated color-black">
                                MI TIENDA
                                <br />
                                SOMO EXPERTOS EN MIS PRUDCTOS
                            </h1>
                            <p class="animated color-gray">Fabricamos todo tipo de productos en madera.</p>
                            {{--<a href="shop-4-column.html" class="shop-btn animated">SHOP NOW</a>--}}
                        </div>
                    </div>
                </div>
                <!-- Single Slider  -->
                <div class="single-slide slider-height-3 bg-img d-flex" data-bg-image="{{asset('images/slider-image/sample-7.jpg')}}">
                    <div class="container align-self-center">
                        <div class="slider-content-1 slider-animated-1 text-left">
                            <h1 class="animated color-black">
                                MI TIENDA
                                <br />
                                SOMO EXPERTOS EN MIS PRUDCTOS
                            </h1>
                            <p class="animated color-gray">Fabricamos todo tipo de productos en madera.</p>
                            {{--<a href="shop-4-column.html" class="shop-btn animated">SHOP NOW</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slider End -->

        <!-- About Area Start -->
        <section class="about-area mtb-50px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="about-left-image mb-md-30px mb-lm-30px ">
                            <img src="{{asset('images/product-image/zoom/1.jpg')}}" alt="ss" class="img-responsive" />
                            <div class="star-box">
                                <span>Puntuación:</span>
                                <div class="rating-product estrellas-productor">
                                    <i class="ion-android-star colorear-estrella"></i>
                                    <i class="ion-android-star colorear-estrella"></i>
                                    <i class="ion-android-star colorear-estrella"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="footer-social-icon d-flex">
                            <div class="heading-info div-titulo-redes">Nuestras Redes Sociales:</div>
                            <div class="social-icon">
                                <ul>
                                    <li class="facebook clasefacebook">
                                        <a href="https://www.facebook.com/sergio.limachigironda/" target="_blank"><i class="ion-social-facebook"></i></a>
                                    </li>
                                    <li class="twitter clasetwitter">
                                        <a href="https://twitter.com/MarquinaRuddy" target="_blank"><i class="ion-social-twitter"></i></a>
                                    </li>
                                    <li class="youtube claseyoutube">
                                        <a href="https://www.youtube.com/channel/UCbIOCIV9CZpXZymjiTrGTYA" target="_blank"><i class="ion-social-youtube"></i></a>
                                    </li>
                                    <li class="instagram claseinstagram">
                                        <a href="https://www.instagram.com/ruddymarquina/" target="_blank"><i class="ion-social-instagram"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="footer-social-icon d-flex">
                            <div class="heading-info div-titulo-redes">Comunicaque con nosotros:</div>
                            <div class="social-icon">
                                <ul>
                                    <li class="clasewhatsapp">
                                        <a href="#" onclick="event.preventDefault();enviarMensajeWhatsapp();"><i class="ion-social-whatsapp"></i></a>
                                    </li>
                                    <li class="twitter clasetwitter">
                                        {{--<a href="https://m.me/sergio.limachigironda" target="_blank"><i class="ion-social-twitter"></i></a>--}}
                                        <a href="https://m.facebook.com/messages/compose?ids=sergio.limachigironda" target="_blank"><i class="ion-social-twitter"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="about-content">
                            <div class="about-title">
                                <h2>Welcome To Abelo</h2>
                            </div>
                            <p class="mb-30px">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore aperiam fugit consequuntur voluptatibus ex sint iure in, distinctio sed dolorem aspernatur veritatis repellendus dolorum voluptate, animi
                                libero officiis eveniet accusamus recusandae. Temporibus amet ducimus sapiente voluptatibus autem dolorem magnam quas, porro suscipit. Quibusdam culpa asperiores exercitationem architecto quo distinctio sed dolorem aspernatur veritatis repellendus dolorum voluptate!
                            </p>
                            <p>
                                Sint voluptatum beatae necessitatibus quos mollitia vero, optio asperiores aut tempora iusto eum rerum, possimus, minus quidem ut saepe laboriosam. Praesentium aperiam accusantium minus repellendus
                                accusamus neque iusto pariatur laudantium provident quod recusandae exercitationem natus dignissimos.
                            </p>

                        </div>
                    </div>
                </div>
                <div class="row mt-50px">
                    <div class="col-md-4 mb-lm-30px">
                        <div class="single-about">
                            <h4>Our Company</h4>
                            <p>
                                Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet conse .
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-lm-30px">
                        <div class="single-about">
                            <h4>Our Team</h4>
                            <p>
                                Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet conse .
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="single-about">
                            <h4>Testimonial</h4>
                            <p>
                                Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet conse .
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Area End -->

        <!--MAPA-->
        <h4>Nuestra Dirección</h4>
        <div id="map" class="map"><div id="popup"></div></div>
        <!--MAPA end-->

        <!-- Shop Category Area End -->
        <div class="shop-category-area mt-30px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Shop Top Area Start -->
                        <div class="shop-top-bar d-flex">
                            <!-- Left Side start -->
                            <div class="shop-tab nav d-flex">
                                <a class="active"  href="#shop-1" data-toggle="tab">
                                    <i class="fa fa-th"></i>
                                </a>
                                {{--<a class="active" href="#shop-2" data-toggle="tab">
                                    <i class="fa fa-list"></i>
                                </a>--}}
                                <p>Nuestros productos: Total 5 productos</p>
                            </div>
                            <!-- Left Side End -->
                            <!-- Right Side Start -->
                            <div class="select-shoing-wrap d-flex">
                                {{--<div class="shot-product">
                                    <p>Sort By:</p>
                                </div>
                                <div class="shop-select">
                                    <select>
                                        <option value="">Sort by newness</option>
                                        <option value="">A to Z</option>
                                        <option value=""> Z to A</option>
                                        <option value="">In stock</option>
                                    </select>
                                </div>--}}
                            </div>
                            <!-- Right Side End -->
                        </div>
                        <!-- Shop Top Area End -->

                        <!-- Shop Bottom Area Start -->
                        <div class="shop-bottom-area mt-35">
                            <!-- Shop Tab Content Start -->
                            <div class="tab-content jump">
                                <!-- Tab One Start -->
                                <div id="shop-1" class="tab-pane active">
                                    <div class="row m-0">
                                        <div class="mb-30px col-md-4 col-lg-3 col-sm-6  p-0">
                                            <div class="slider-single-item">
                                                <!-- Single Item -->
                                                <article class="list-product p-0 text-center">
                                                    <div class="product-inner">
                                                        <div class="img-block">
                                                            <a href="single-product.html" class="thumbnail">
                                                                <img class="first-img" src="{{asset('images/product-image/8.jpg')}}" alt="" />
                                                                <img class="second-img" src="{{asset('images/product-image/9.jpg')}}" alt="" />
                                                            </a>
                                                            <div class="add-to-link">
                                                                {{--<ul>
                                                                    <li>
                                                                        <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                                                            <i class="lnr lnr-magnifier"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="wishlist.html" title="Add to Wishlist"><i class="lnr lnr-heart"></i></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="compare.html" title="Add to compare"><i class="lnr lnr-sync"></i></a>
                                                                    </li>
                                                                </ul>--}}
                                                            </div>
                                                        </div>
                                                        <ul class="product-flag">
                                                            <li class="new">-12%</li>
                                                        </ul>
                                                        <div class="product-decs">
                                                            <a class="inner-link" href="shop-4-column.html"><span>STUDIO DESIGN</span></a>
                                                            <h2><a href="single-product.html" class="product-link">SoundBox Pro Portable</a></h2>
                                                            <div class="pricing-meta">
                                                                <ul>
                                                                    <li class="old-price">$23.90</li>
                                                                    <li class="current-price">$21.51</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="cart-btn">
                                                            <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                        </div>
                                                    </div>
                                                </article>
                                                <!-- Single Item -->
                                            </div>
                                        </div>
                                        <div class="mb-30px col-md-4 col-lg-3 col-sm-6  p-0">
                                            <div class="slider-single-item">
                                                <!-- Single Item -->
                                                <article class="list-product p-0 text-center">
                                                    <div class="product-inner">
                                                        <div class="img-block">
                                                            <a href="single-product.html" class="thumbnail">
                                                                <img class="first-img" src="{{asset('images/product-image/12.jpg')}}" alt="" />
                                                                <img class="second-img" src="{{asset('images/product-image/13.jpg')}}" alt="" />
                                                            </a>
                                                            <div class="add-to-link">
                                                                {{--<ul>
                                                                    <li>
                                                                        <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                                                            <i class="lnr lnr-magnifier"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="wishlist.html" title="Add to Wishlist"><i class="lnr lnr-heart"></i></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="compare.html" title="Add to compare"><i class="lnr lnr-sync"></i></a>
                                                                    </li>
                                                                </ul>--}}
                                                            </div>
                                                        </div>
                                                        <div class="product-decs">
                                                            <a class="inner-link" href="shop-4-column.html"><span>GRAPHIC CORNER1</span></a>
                                                            <h2><a href="single-product.html" class="product-link">Naham WiFi HD 1080P</a></h2>
                                                            <div class="pricing-meta">
                                                                <ul>
                                                                    <li class="current-price">$21.51</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="cart-btn">
                                                            <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>

                                        <div class="mb-30px col-md-4 col-lg-3 col-sm-6  p-0">
                                            <div class="slider-single-item">
                                                <!-- Single Item -->
                                                <article class="list-product p-0 text-center">
                                                    <div class="product-inner">
                                                        <div class="img-block">
                                                            <a href="single-product.html" class="thumbnail">
                                                                <img class="first-img" src="{{asset('images/product-image/12.jpg')}}" alt="" />
                                                                <img class="second-img" src="{{asset('images/product-image/13.jpg')}}" alt="" />
                                                            </a>
                                                            <div class="add-to-link">
                                                                {{--<ul>
                                                                    <li>
                                                                        <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                                                            <i class="lnr lnr-magnifier"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="wishlist.html" title="Add to Wishlist"><i class="lnr lnr-heart"></i></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="compare.html" title="Add to compare"><i class="lnr lnr-sync"></i></a>
                                                                    </li>
                                                                </ul>--}}
                                                            </div>
                                                        </div>
                                                        <div class="product-decs">
                                                            <a class="inner-link" href="shop-4-column.html"><span>GRAPHIC CORNER1</span></a>
                                                            <h2><a href="single-product.html" class="product-link">Naham WiFi HD 1080P</a></h2>
                                                            <div class="pricing-meta">
                                                                <ul>
                                                                    <li class="current-price">$21.51</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="cart-btn">
                                                            <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>

                                        <div class="mb-30px col-md-4 col-lg-3 col-sm-6  p-0">
                                            <div class="slider-single-item">
                                                <!-- Single Item -->
                                                <article class="list-product p-0 text-center">
                                                    <div class="product-inner">
                                                        <div class="img-block">
                                                            <a href="single-product.html" class="thumbnail">
                                                                <img class="first-img" src="{{asset('images/product-image/12.jpg')}}" alt="" />
                                                                <img class="second-img" src="{{asset('images/product-image/13.jpg')}}" alt="" />
                                                            </a>
                                                            <div class="add-to-link">
                                                                {{--<ul>
                                                                    <li>
                                                                        <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                                                            <i class="lnr lnr-magnifier"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="wishlist.html" title="Add to Wishlist"><i class="lnr lnr-heart"></i></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="compare.html" title="Add to compare"><i class="lnr lnr-sync"></i></a>
                                                                    </li>
                                                                </ul>--}}
                                                            </div>
                                                        </div>
                                                        <div class="product-decs">
                                                            <a class="inner-link" href="shop-4-column.html"><span>GRAPHIC CORNER1</span></a>
                                                            <h2><a href="single-product.html" class="product-link">Naham WiFi HD 1080P</a></h2>
                                                            <div class="pricing-meta">
                                                                <ul>
                                                                    <li class="current-price">$21.51</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="cart-btn">
                                                            <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>

                                        <div class="mb-30px col-md-4 col-lg-3 col-sm-6  p-0">
                                            <div class="slider-single-item">
                                                <!-- Single Item -->
                                                <article class="list-product p-0 text-center">
                                                    <div class="product-inner">
                                                        <div class="img-block">
                                                            <a href="single-product.html" class="thumbnail">
                                                                <img class="first-img" src="{{asset('images/product-image/12.jpg')}}" alt="" />
                                                                <img class="second-img" src="{{asset('images/product-image/13.jpg')}}" alt="" />
                                                            </a>
                                                            <div class="add-to-link">
                                                                {{--<ul>
                                                                    <li>
                                                                        <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                                                            <i class="lnr lnr-magnifier"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="wishlist.html" title="Add to Wishlist"><i class="lnr lnr-heart"></i></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="compare.html" title="Add to compare"><i class="lnr lnr-sync"></i></a>
                                                                    </li>
                                                                </ul>--}}
                                                            </div>
                                                        </div>
                                                        <div class="product-decs">
                                                            <a class="inner-link" href="shop-4-column.html"><span>GRAPHIC CORNER1</span></a>
                                                            <h2><a href="single-product.html" class="product-link">Naham WiFi HD 1080P</a></h2>
                                                            <div class="pricing-meta">
                                                                <ul>
                                                                    <li class="current-price">$21.51</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="cart-btn">
                                                            <a href="#" class="add-to-curt" title="Add to cart">Add to cart</a>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- Tab One End -->
                            </div>
                            <!-- Shop Tab Content End -->
                        </div>
                        <!-- Shop Bottom Area End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Shop Category Area End -->

        <!-- product details description area start -->
        <div class="description-review-area mb-50px bg-light-gray-3 ptb-50px">
            <div class="container">
                <div class="description-review-wrapper">
                    <div class="description-review-topbar nav">
                        <a class="active" data-toggle="tab" href="#des-details3">Valoraciones</a>
                    </div>
                    <div class="tab-content description-review-bottom">
                        <div id="des-details3" class="tab-pane active">
                            <div class="row">
                                <div class="col-lg-7 div-comentarios" id="div-comentarios">
                                    <div class="review-wrapper">
                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="assets/images/review-image/1.png" alt="" />
                                            </div>
                                            <div class="review-content">
                                                <div class="review-top-wrap">
                                                    <div class="review-left">
                                                        <div class="review-name">
                                                            <h4>White Lewis sjsjsjs jsuwnnsjusn sssdss</h4>
                                                        </div>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star sincolor-estrella"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                    </div>
                                                    <div class="review-left">
                                                        {{--<a href="#">Reply</a>--}}
                                                    </div>
                                                </div>
                                                <div class="review-bottom">
                                                    <p>
                                                        Vestibulum ante ipsum primis aucibus orci luctustrices posuere cubilia Curae Suspendisse viverra ed viverra. Mauris ullarper euismod vehicula. Phasellus quam nisi, congue id nulla.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="assets/images/review-image/2.png" alt="" />
                                            </div>
                                            <div class="review-content">
                                                <div class="review-top-wrap">
                                                    <div class="review-left">
                                                        <div class="review-name">
                                                            <h4>White Lewis</h4>
                                                        </div>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                    </div>
                                                    <div class="review-left">
                                                        <a href="#">Reply</a>
                                                    </div>
                                                </div>
                                                <div class="review-bottom">
                                                    <p>Vestibulum ante ipsum primis aucibus orci luctustrices posuere cubilia Curae Sus pen disse viverra ed viverra. Mauris ullarper euismod vehicula.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="assets/images/review-image/2.png" alt="" />
                                            </div>
                                            <div class="review-content">
                                                <div class="review-top-wrap">
                                                    <div class="review-left">
                                                        <div class="review-name">
                                                            <h4>White Lewis</h4>
                                                        </div>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                    </div>
                                                    <div class="review-left">
                                                        <a href="#">Reply</a>
                                                    </div>
                                                </div>
                                                <div class="review-bottom">
                                                    <p>Vestibulum ante ipsum primis aucibus orci luctustrices posuere cubilia Curae Sus pen disse viverra ed viverra. Mauris ullarper euismod vehicula.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="assets/images/review-image/2.png" alt="" />
                                            </div>
                                            <div class="review-content">
                                                <div class="review-top-wrap">
                                                    <div class="review-left">
                                                        <div class="review-name">
                                                            <h4>White Lewis</h4>
                                                        </div>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                    </div>
                                                    <div class="review-left">
                                                        <a href="#">Reply</a>
                                                    </div>
                                                </div>
                                                <div class="review-bottom">
                                                    <p>Vestibulum ante ipsum primis aucibus orci luctustrices posuere cubilia Curae Sus pen disse viverra ed viverra. Mauris ullarper euismod vehicula.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="assets/images/review-image/2.png" alt="" />
                                            </div>
                                            <div class="review-content">
                                                <div class="review-top-wrap">
                                                    <div class="review-left">
                                                        <div class="review-name">
                                                            <h4>White Lewis</h4>
                                                        </div>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                    </div>
                                                    <div class="review-left">
                                                        <a href="#">Reply</a>
                                                    </div>
                                                </div>
                                                <div class="review-bottom">
                                                    <p>Vestibulum ante ipsum primis aucibus orci luctustrices posuere cubilia Curae Sus pen disse viverra ed viverra. Mauris ullarper euismod vehicula.</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="ratting-form-wrapper pl-50">
                                        <h3>Add a Review</h3>
                                        <div class="ratting-form">
                                            <form action="#">
                                                <div class="star-box">
                                                    <span>Your rating:</span>
                                                    <div class="rating-product">
                                                        <i class="ion-android-star"></i>
                                                        <i class="ion-android-star"></i>
                                                        <i class="ion-android-star"></i>
                                                        <i class="ion-android-star"></i>
                                                        <i class="ion-android-star"></i>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="rating-form-style mb-10">
                                                            <input placeholder="Name" id="name" type="text" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="rating-form-style mb-10">
                                                            <input placeholder="Email" type="email" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="rating-form-style form-submit">
                                                            <textarea name="Your Review" placeholder="Message"></textarea>
                                                            <input type="submit" value="Submit" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- product details description area end -->

    </div>

@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{asset('js/ol.js')}}"></script>
    <script>
        @php
            $latitud = -17.392409;
            $longitud = -66.159072;
            $direccion = 'Dirección de la tienda, ubicada entre las calles Ayacucho y Heroinas, esquina sur edificio Herbas N°232';
            $zoom = 16;
        @endphp
        var latitud = {{$latitud}};
        var longitud = {{$longitud}};
        var direccion = '{{$direccion}}';
        var zoom = {{$zoom}};
        $(document).ready(function(){
            //$("#div-comentarios").scroll
            //el scroll de comentarios hacia abajo
            //$("#div-comentarios").animate({ scrollTop: $('#div-comentarios').height()}, 1000);
            //el scroll de comentarios hacia arriba
            $("#div-comentarios").animate({ scrollTop: 0}, 1000);
            validarInputEntero('#name');

            var iconFeature = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([longitud, latitud])),
                name: direccion,
                population: 4000,
                rainfall: 500
            });

            var iconStyle = new ol.style.Style({
                image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                    anchor: [0.5, 46],
                    anchorXUnits: 'fraction',
                    anchorYUnits: 'pixels',
                    src: '{{asset('images/icons/icon.png')}}'
                }))
            });

            iconFeature.setStyle(iconStyle);

            var vectorSource = new ol.source.Vector({
                features: [iconFeature]
            });

            var vectorLayer = new ol.layer.Vector({
                source: vectorSource
            });

            var osm = new ol.layer.Tile({
                source: new ol.source.OSM()
            });

            var map = new ol.Map({
                layers: [ osm,vectorLayer],
                target: document.getElementById('map'),
                view: new ol.View({
                    center: ol.proj.fromLonLat([longitud, latitud]),
                    zoom: zoom
                })
            });

            var element = document.getElementById('popup');

            var popup = new ol.Overlay({
                element: element,
                positioning: 'bottom-center',
                stopEvent: false,
                offset: [0, -50]
            });
            map.addOverlay(popup);

            // display popup on click
            map.on('click', function(evt) {
                var feature = map.forEachFeatureAtPixel(evt.pixel,
                    function(feature) {
                        return feature;
                    });
                if (feature) {
                    var coordinates = feature.getGeometry().getCoordinates();
                    popup.setPosition(coordinates);
                    $(element).popover({
                        'placement': 'top',
                        'html': true,
                        'content': feature.get('name')
                    });
                    $(element).popover('toggle');
                } else {
                    $(element).popover('dispose');
                }
            });

            // change mouse cursor when over marker
            map.on('pointermove', function(e) {
                if (e.dragging) {
                    $(element).popover('dispose');
                    return;
                }
                var pixel = map.getEventPixel(e.originalEvent);
                var hit = map.hasFeatureAtPixel(pixel);
                map.getTarget().style.cursor = hit ? 'pointer' : '';
            });

            //mostramos de entrada el popup
            /*var coordinates = ol.proj.fromLonLat([longitud, latitud]);
            popup.setPosition(coordinates);
            $(element).popover({
                'placement': 'top',
                'html': true,
                'content': direccion
            });
            $(element).popover('show');*/

        });

        function enviarMensajeWhatsapp() {

            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            if (isMobile) {
                console.log('es mobil');
                window.open(
                    'https://api.whatsapp.com/send?phone=59177974242&text=Hola%20quisiera%20conocer%20mas%20sobre%20su%20sistema',
                    '_blank'
                );
            } else {
                console.log('es escritorio');
                window.open(
                    'https://web.whatsapp.com/send?phone=59177974242&text=Hola%20quisiera%20conocer%20mas%20sobre%20su%20sistema',
                    '_blank'
                );
            }

        }

    </script>
@stop
