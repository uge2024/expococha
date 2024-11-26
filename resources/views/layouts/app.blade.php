<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Favicon -->
    {{--<link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon/favicon.png')}}" />--}}
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Muli:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" type="text/css" media="all">

    <!-- CSS
  ============================================ -->

    <!-- Vendor CSS (Bootstrap & Icon Font) -->
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor/linearicon.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor/sofiaPro.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor/font-awesome.min.css')}}">

    <!-- Plugins CSS (All Plugins Files) -->
    <link rel="stylesheet" href="{{asset('css/plugins/animate.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/slick.css')}}">

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <!-- <link rel="stylesheet" href="assets/css/vendor/vendor.min.css" />
        <link rel="stylesheet" href="assets/css/plugins/plugins.min.css" />
        <link rel="stylesheet" href="assets/css/style.min.css"> -->

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
    @yield('header_styles')
</head>

<body>
<!-- Header Section Start From Here -->
<header class="header-wrapper">
    <!-- Header Nav Start -->
    <div class="header-nav d-lg-none">
        <div class="container">
            <div class="header-nav-wrapper d-md-flex d-sm-flex d-xl-flex d-lg-flex justify-content-between">
                <div class="header-static-nav">
                    <a href="mailto:yourname@email.com">yourname@email.com</a>
                </div>
                <div class="header-menu-nav">
                    <ul class="menu-nav">
                        <li>
                            <div class="dropdown">
                                <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account <i class="ion-ios-arrow-down"></i></button>

                                <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton">
                                    @guest
                                        <li><a href="{{ route('login') }}">Ingresar</a></li>
                                        @if (Route::has('register'))
                                            <li><a href="{{ route('register') }}">Registrarse</a></li>
                                        @endif
                                    @else
                                        <li><a href="my-account.html">Mi cuenta</a></li>
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
                        <li>
                            <div class="dropdown">
                                <button type="button" id="dropdownMenuButton-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">USD $ <i class="ion-ios-arrow-down"></i></button>

                                <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton-2">
                                    <li><a href="#">EUR €</a></li>
                                    <li><a href="#">USD $</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="pr-0">
                            <div class="dropdown">
                                <button type="button" id="dropdownMenuButton-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="images/flag/1.jpg" alt="" /> English <i class="ion-ios-arrow-down"></i>
                                </button>

                                <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton-3">
                                    <li>
                                        <a href="#"><img src="images/flag/1.jpg" alt="" /> English</a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="images/flag/2.jpg" alt="" /> Français</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Nav End -->
    <div class="header-top header-style-3 bg-white sticky-nav ptb-10px d-lg-block d-none">
        <div class="container">
            <div class="row">
                <div class="col-md-2 d-flex">
                    <div class="logo align-self-center">
                        <a href="index.html"><img class="img-responsive" src="images/logo/logo.jpg" alt="logo.jpg" /></a>
                    </div>
                </div>
                <div class="col-md-6 align-self-center header-menu-3">
                    <div class="header-horizontal-menu">
                        <ul class="menu-content">
                            <li class="active menu-dropdown">
                                <a href="#">Home <i class="ion-ios-arrow-down"></i></a>
                                <ul class="main-sub-menu">
                                    <li><a href="index.html">Home 1</a></li>
                                    <li><a href="index-2.html">Home 2</a></li>
                                    <li><a href="index-3.html">Home 3</a></li>
                                    <li><a href="index-4.html">Home 4</a></li>
                                </ul>
                            </li>
                            <li class="menu-dropdown">
                                <a href="#">Shop <i class="ion-ios-arrow-down"></i></a>
                                <ul class="mega-menu-wrap">
                                    <li>
                                        <ul>
                                            <li class="mega-menu-title"><a href="#">Shop Grid</a></li>
                                            <li><a href="shop-3-column.html">Shop Grid 3 Column</a></li>
                                            <li><a href="shop-4-column.html">Shop Grid 4 Column</a></li>
                                            <li><a href="shop-left-sidebar.html">Shop Grid Left Sidebar</a></li>
                                            <li><a href="shop-right-sidebar.html">Shop Grid Right Sidebar</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul>
                                            <li class="mega-menu-title"><a href="#">Shop List</a></li>
                                            <li><a href="shop-list.html">Shop List</a></li>
                                            <li><a href="shop-list-left-sidebar.html">Shop List Left Sidebar</a></li>
                                            <li><a href="shop-list-right-sidebar.html">Shop List Right Sidebar</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul>
                                            <li class="mega-menu-title"><a href="#">Shop Single</a></li>
                                            <li><a href="single-product.html">Shop Single</a></li>
                                            <li><a href="single-product-variable.html">Shop Variable</a></li>
                                            <li><a href="single-product-affiliate.html">Shop Affiliate</a></li>
                                            <li><a href="single-product-group.html">Shop Group</a></li>
                                            <li><a href="single-product-tabstyle-2.html">Shop Tab 2</a></li>
                                            <li><a href="single-product-tabstyle-3.html">Shop Tab 3</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul>
                                            <li class="mega-menu-title"><a href="#">Shop Single</a></li>
                                            <li><a href="single-product-slider.html">Shop Slider</a></li>
                                            <li><a href="single-product-gallery-left.html">Shop Gallery Left</a></li>
                                            <li><a href="single-product-gallery-right.html">Shop Gallery Right</a></li>
                                            <li><a href="single-product-sticky-left.html">Shop Sticky Left</a></li>
                                            <li><a href="single-product-sticky-right.html">Shop Sticky Right</a></li>
                                        </ul>
                                    </li>
                                    <li class="w-100">
                                        <ul class="banner-megamenu-wrapper d-flex">
                                            <li class="banner-wrapper mr-30px">
                                                <a href="single-product.html"><img src="images/menu-image/banner-menu2.jpg" alt="" /></a>
                                            </li>
                                            <li class="banner-wrapper">
                                                <a href="single-product.html"><img src="images/menu-image/banner-menu3.jpg" alt="" /></a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-dropdown">
                                <a href="#">Pages <i class="ion-ios-arrow-down"></i></a>
                                <ul class="main-sub-menu">
                                    <li><a href="about.html">About Page</a></li>
                                    <li><a href="cart.html">Cart Page</a></li>
                                    <li><a href="checkout.html">Checkout Page</a></li>
                                    <li><a href="compare.html">Compare Page</a></li>
                                    <li><a href="login.html">Login & Register Page</a></li>
                                    <li><a href="my-account.html">Account Page</a></li>
                                    <li><a href="empty-cart.html">Empty Cart Page</a></li>
                                    <li><a href="404.html">404 Page</a></li>
                                    <li><a href="wishlist.html">Wishlist Page</a></li>
                                </ul>
                            </li>
                            <li class="menu-dropdown">
                                <a href="#">Blog <i class="ion-ios-arrow-down"></i></a>
                                <ul class="main-sub-menu">
                                    <li class="menu-dropdown position-static">
                                        <a href="#">Blog Grid <i class="ion-ios-arrow-right"></i></a>
                                        <ul class="main-sub-menu main-sub-menu-2">
                                            <li><a href="blog-grid-left-sidebar.html">Blog Grid Left Sidebar</a></li>
                                            <li><a href="blog-grid-right-sidebar.html">Blog Grid Right Sidebar</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-dropdown position-static">
                                        <a href="#">Blog List <i class="ion-ios-arrow-right"></i></a>
                                        <ul class="main-sub-menu main-sub-menu-2">
                                            <li><a href="blog-list-left-sidebar.html">Blog List Left Sidebar</a></li>
                                            <li><a href="blog-list-right-sidebar.html">Blog List Right Sidebar</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-dropdown position-static">
                                        <a href="#">Blog Single <i class="ion-ios-arrow-right"></i></a>
                                        <ul class="main-sub-menu main-sub-menu-2">
                                            <li><a href="blog-single-left-sidebar.html">Blog Single Left Sidebar</a></li>
                                            <li><a href="blog-single-right-sidebar.html">Blog Single Right Sidbar</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-dropdown">
                                <a href="#">Custom Menu <i class="ion-ios-arrow-down"></i></a>
                                <ul class="mega-menu-wrap mega-menu-wrap-2">
                                    <li>
                                        <div class="custom-single-item">
                                            <h4><a href="shop-4-column.html">Women Is Clothes & Fashion</a></h4>
                                            <p>Shop Women Is Clothing And Accessories And Get Inspired By The Latest Fashion Trends.</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-single-item">
                                            <h4><a href="shop-4-column.html">Simple Style</a></h4>
                                            <p>A New Flattering Style With All The Comfort Of Our Linen.</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-single-item">
                                            <h4><a href="shop-4-column.html">Easy Style</a></h4>
                                            <p>Endless Styling Possibilities In A Collection Full Of Versatile Pieces.</p>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="contact.html">contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 text-right align-self-center header-nav ">
                    <div class="header-menu-nav">
                        <ul class="menu-nav">
                            <li>
                                <div class="dropdown">
                                    <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account <i class="ion-ios-arrow-down"></i></button>

                                    <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton">
                                        <li><a href="my-account.html">My account</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                        <li><a href="login.html">Sign in</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown">
                                    <button type="button" id="dropdownMenuButton-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">USD $ <i class="ion-ios-arrow-down"></i></button>

                                    <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton-2">
                                        <li><a href="#">EUR €</a></li>
                                        <li><a href="#">USD $</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="pr-0">
                                <div class="dropdown">
                                    <button type="button" id="dropdownMenuButton-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="images/flag/1.jpg" alt="" /> English <i class="ion-ios-arrow-down"></i>
                                    </button>

                                    <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton-3">
                                        <li>
                                            <a href="#"><img src="images/flag/1.jpg" alt="" /> English</a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="images/flag/2.jpg" alt="" /> Français</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Nav End -->
    <div class="header-menu header-menu-style-3 bg-blue  d-lg-block d-none ptb-13px">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header-menu-vertical">
                        <h4 class="menu-title">Browse Categories </h4>
                        <ul class="menu-content display-none">
                            <li class="menu-item"><a href="#">Televisions</a></li>
                            <li class="menu-item">
                                <a href="#">Electronics <i class="ion-ios-arrow-right"></i></a>
                                <ul class="sub-menu flex-wrap">
                                    <li>
                                        <a href="#">
                                            <span> <strong> Accessories & Parts</strong></span>
                                        </a>
                                        <ul class="submenu-item">
                                            <li><a href="#">Cables & Adapters</a></li>
                                            <li><a href="#">Batteries</a></li>
                                            <li><a href="#">Chargers</a></li>
                                            <li><a href="#">Bags & Cases</a></li>
                                            <li><a href="#">Electronic Cigarettes</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span><strong>Camera & Photo</strong></span>
                                        </a>
                                        <ul class="submenu-item">
                                            <li><a href="#">Digital Cameras</a></li>
                                            <li><a href="#">Camcorders</a></li>
                                            <li><a href="#">Camera Drones</a></li>
                                            <li><a href="#">Action Cameras</a></li>
                                            <li><a href="#">Photo Studio Supplie</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span><strong>Smart Electronics</strong></span>
                                        </a>
                                        <ul class="submenu-item">
                                            <li><a href="#">Wearable Devices</a></li>
                                            <li><a href="#">Smart Home Appliances</a></li>
                                            <li><a href="#">Smart Remote Controls</a></li>
                                            <li><a href="#">Smart Watches</a></li>
                                            <li><a href="#">Smart Wristbands</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span><strong>Audio & Video</strong></span>
                                        </a>
                                        <ul class="submenu-item">
                                            <li><a href="#">Televisions</a></li>
                                            <li><a href="#">TV Receivers</a></li>
                                            <li><a href="#">Projectors</a></li>
                                            <li><a href="#">Audio Amplifier Boards</a></li>
                                            <li><a href="#">TV Sticks</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <!-- sub menu -->
                            </li>
                            <li class="menu-item">
                                <a href="#">Video Games <i class="ion-ios-arrow-right"></i></a>
                                <ul class="sub-menu sub-menu-2">
                                    <li>
                                        <ul class="submenu-item">
                                            <li><a href="#">Handheld Game Players</a></li>
                                            <li><a href="#">Game Controllers</a></li>
                                            <li><a href="#">Joysticks</a></li>
                                            <li><a href="#">Stickers</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <!-- sub menu -->
                            </li>
                            <li class="menu-item"><a href="#">Digital Cameras</a></li>
                            <li class="menu-item"><a href="#">Headphones</a></li>
                            <li class="menu-item"><a href="#"> Wearable Devices</a></li>
                            <li class="menu-item"><a href="#"> Smart Watches</a></li>
                            <li class="menu-item"><a href="#"> Game Controllers</a></li>
                            <li class="menu-item"><a href="#"> Smart Home Appliances</a></li>
                        </ul>
                        <!-- menu content -->
                    </div>
                    <!-- header menu vertical -->
                </div>
                <div class="col-lg-7">
                    <div class="header-right-element d-flex">
                        <div class="search-element media-body">
                            <form class="d-flex" action="#">
                                <div class="search-category">
                                    <select>
                                        <option value="0">All categories</option>
                                        <option value="12">Laptop</option>
                                        <option value="13">- - Hot Categories</option>
                                        <option value="19">- - - - Dresses</option>
                                        <option value="20">- - - - Jackets &amp; Coats</option>
                                        <option value="21">- - - - Sweaters</option>
                                        <option value="22">- - - - Jeans</option>
                                        <option value="23">- - - - Blouses &amp; Shirts</option>
                                        <option value="14">- - Outerwear &amp; Jackets</option>
                                        <option value="24">- - - - Basic Jackets</option>
                                        <option value="25">- - - - Real Fur</option>
                                        <option value="26">- - - - Down Coats</option>
                                        <option value="27">- - - - Blazers</option>
                                        <option value="28">- - - - Trench Coats</option>
                                        <option value="15">- - Weddings &amp; Events</option>
                                        <option value="29">- - - - Wedding Dresses</option>
                                        <option value="30">- - - - Evening Dresses</option>
                                        <option value="31">- - - - Prom Dresses</option>
                                        <option value="32">- - - - Bridesmaid Dresses</option>
                                        <option value="33">- - - - Wedding Accessories</option>
                                        <option value="16">- - Bottoms</option>
                                        <option value="34">- - - - Skirts</option>
                                        <option value="35">- - - - Leggings</option>
                                        <option value="36">- - - - Pants &amp; Capris</option>
                                        <option value="37">- - - - Wide Leg Pants</option>
                                        <option value="38">- - - - Shorts</option>
                                        <option value="17">- - Tops &amp; Sets</option>
                                        <option value="39">- - - - Tank Tops</option>
                                        <option value="40">- - - - Suits &amp; Sets</option>
                                        <option value="41">- - - - Jumpsuits</option>
                                        <option value="42">- - - - Rompers</option>
                                        <option value="43">- - - - Sleep &amp; Lounge</option>
                                        <option value="18">- - Accessories</option>
                                        <option value="44">- - - - Eyewear &amp; Accessories</option>
                                        <option value="45">- - - - Hats &amp; Caps</option>
                                        <option value="46">- - - - Belts &amp; Cummerbunds</option>
                                        <option value="47">- - - - Scarves &amp; Wraps</option>
                                        <option value="48">- - - - Gloves &amp; Mittens</option>
                                        <option value="49">Computer</option>
                                        <option value="50">- - Bottoms</option>
                                        <option value="53">- - - - Skirts</option>
                                        <option value="54">- - - - Leggings</option>
                                        <option value="55">- - - - Jeans</option>
                                        <option value="56">- - - - Pants &amp; Capris</option>
                                        <option value="57">- - - - Shorts</option>
                                        <option value="51">- - Outerwear &amp; Jackets</option>
                                        <option value="58">- - - - Trench</option>
                                        <option value="59">- - - - Genuine Leather</option>
                                        <option value="60">- - - - Parkas</option>
                                        <option value="61">- - - - Down Jackets</option>
                                        <option value="62">- - - - Wool &amp; Blends</option>
                                        <option value="52">- - Underwear &amp; Loungewear</option>
                                        <option value="63">- - - - Boxers</option>
                                        <option value="64">- - - - Briefs</option>
                                        <option value="65">- - - - Long Johns</option>
                                        <option value="66">- - - - Men's Sleep &amp; Lounge</option>
                                        <option value="67">- - - - Pajama Sets</option>
                                        <option value="68">Smartphone</option>
                                        <option value="69">- - Accessories &amp; Parts</option>
                                        <option value="75">- - - - Cables &amp; Adapters</option>
                                        <option value="76">- - - - Batteries</option>
                                        <option value="77">- - - - Chargers</option>
                                        <option value="78">- - - - Bags &amp; Cases</option>
                                        <option value="79">- - - - Electronic Cigarettes</option>
                                        <option value="70">- - Audio &amp; Video</option>
                                        <option value="80">- - - - Televisions</option>
                                        <option value="81">- - - - TV Receivers</option>
                                        <option value="82">- - - - Projectors</option>
                                        <option value="83">- - - - Audio Amplifier Boards</option>
                                        <option value="84">- - - - TV Sticks</option>
                                        <option value="71">- - Camera &amp; Photo</option>
                                        <option value="85">- - - - Digital Cameras</option>
                                        <option value="86">- - - - Camcorders</option>
                                        <option value="87">- - - - Camera Drones</option>
                                        <option value="88">- - - - Action Cameras</option>
                                        <option value="89">- - - - Photo Studio Supplies</option>
                                        <option value="72">- - Portable Audio &amp; Video</option>
                                        <option value="90">- - - - Headphones</option>
                                        <option value="91">- - - - Speakers</option>
                                        <option value="92">- - - - MP3 Players</option>
                                        <option value="93">- - - - VR/AR Devices</option>
                                        <option value="94">- - - - Microphones</option>
                                        <option value="73">- - Smart Electronics</option>
                                        <option value="95">- - - - Wearable Devices</option>
                                        <option value="96">- - - - Smart Home Appliances</option>
                                        <option value="97">- - - - Smart Remote Controls</option>
                                        <option value="98">- - - - Smart Watches</option>
                                        <option value="99">- - - - Smart Wristbands</option>
                                        <option value="74">- - Video Games</option>
                                        <option value="100">- - - - Handheld Game Players</option>
                                        <option value="101">- - - - Game Controllers</option>
                                        <option value="102">- - - - Joysticks</option>
                                        <option value="103">- - - - Stickers</option>
                                        <option value="104">Game Consoles</option>
                                        <option value="105">Mp3 &amp; headphone</option>
                                        <option value="106">Tv &amp; Video</option>
                                        <option value="107">Watches</option>
                                        <option value="108">Washing Machine</option>
                                        <option value="109">Camera</option>
                                        <option value="110">Audio &amp; Theater</option>
                                        <option value="111">Accessories</option>
                                        <option value="112">Games &amp; Consoles</option>
                                    </select>
                                </div>
                                <input type="text" placeholder="Enter your search key ... " />
                                <button>Search</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!--Cart info Start -->
                <div class="col-lg-3 text-right">
                    <div class="header-tools">
                        <div class="cart-info align-self-center">
                            <a href="#offcanvas-wishlist" class="heart offcanvas-toggle"><i class="lnr lnr-heart"></i><span>Wishlist</span></a>
                            <a href="#offcanvas-cart" class="bag offcanvas-toggle"><i class="lnr lnr-cart"></i><span>My Cart</span></a>
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
</header>
<!-- Header Section End Here -->

<!-- Mobile Header Section Start -->
<div class="mobile-header d-lg-none sticky-nav bg-white ptb-20px">
    <div class="container">
        <div class="row align-items-center">

            <!-- Header Logo Start -->
            <div class="col">
                <div class="header-logo">
                    <a href="index.html"><img class="img-responsive" src="images/logo/logo.jpg" alt="logo.jpg" /></a>
                </div>
            </div>
            <!-- Header Logo End -->

            <!-- Header Tools Start -->
            <div class="col-auto">
                <div class="header-tools justify-content-end">
                    <div class="cart-info d-flex align-self-center">
                        <a href="#offcanvas-wishlist" class="heart offcanvas-toggle"><i class="lnr lnr-heart"></i><span>Wishlist</span></a>
                        <a href="#offcanvas-cart" class="bag offcanvas-toggle"><i class="lnr lnr-cart"></i><span>My Cart</span></a>
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

<!-- Search Category Start -->
<div class="mobile-search-area d-lg-none mb-15px">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="search-element media-body">
                    <form class="d-flex" action="#">
                        <div class="search-category">
                            <select>
                                <option value="0">All categories</option>
                                <option value="12">Laptop</option>
                                <option value="13">- - Hot Categories</option>
                                <option value="19">- - - - Dresses</option>
                                <option value="20">- - - - Jackets &amp; Coats</option>
                                <option value="21">- - - - Sweaters</option>
                                <option value="22">- - - - Jeans</option>
                                <option value="23">- - - - Blouses &amp; Shirts</option>
                                <option value="14">- - Outerwear &amp; Jackets</option>
                                <option value="24">- - - - Basic Jackets</option>
                                <option value="25">- - - - Real Fur</option>
                                <option value="26">- - - - Down Coats</option>
                                <option value="27">- - - - Blazers</option>
                                <option value="28">- - - - Trench Coats</option>
                                <option value="15">- - Weddings &amp; Events</option>
                                <option value="29">- - - - Wedding Dresses</option>
                                <option value="30">- - - - Evening Dresses</option>
                                <option value="31">- - - - Prom Dresses</option>
                                <option value="32">- - - - Bridesmaid Dresses</option>
                                <option value="33">- - - - Wedding Accessories</option>
                                <option value="16">- - Bottoms</option>
                                <option value="34">- - - - Skirts</option>
                                <option value="35">- - - - Leggings</option>
                                <option value="36">- - - - Pants &amp; Capris</option>
                                <option value="37">- - - - Wide Leg Pants</option>
                                <option value="38">- - - - Shorts</option>
                                <option value="17">- - Tops &amp; Sets</option>
                                <option value="39">- - - - Tank Tops</option>
                                <option value="40">- - - - Suits &amp; Sets</option>
                                <option value="41">- - - - Jumpsuits</option>
                                <option value="42">- - - - Rompers</option>
                                <option value="43">- - - - Sleep &amp; Lounge</option>
                                <option value="18">- - Accessories</option>
                                <option value="44">- - - - Eyewear &amp; Accessories</option>
                                <option value="45">- - - - Hats &amp; Caps</option>
                                <option value="46">- - - - Belts &amp; Cummerbunds</option>
                                <option value="47">- - - - Scarves &amp; Wraps</option>
                                <option value="48">- - - - Gloves &amp; Mittens</option>
                                <option value="49">Computer</option>
                                <option value="50">- - Bottoms</option>
                                <option value="53">- - - - Skirts</option>
                                <option value="54">- - - - Leggings</option>
                                <option value="55">- - - - Jeans</option>
                                <option value="56">- - - - Pants &amp; Capris</option>
                                <option value="57">- - - - Shorts</option>
                                <option value="51">- - Outerwear &amp; Jackets</option>
                                <option value="58">- - - - Trench</option>
                                <option value="59">- - - - Genuine Leather</option>
                                <option value="60">- - - - Parkas</option>
                                <option value="61">- - - - Down Jackets</option>
                                <option value="62">- - - - Wool &amp; Blends</option>
                                <option value="52">- - Underwear &amp; Loungewear</option>
                                <option value="63">- - - - Boxers</option>
                                <option value="64">- - - - Briefs</option>
                                <option value="65">- - - - Long Johns</option>
                                <option value="66">- - - - Men's Sleep &amp; Lounge</option>
                                <option value="67">- - - - Pajama Sets</option>
                                <option value="68">Smartphone</option>
                                <option value="69">- - Accessories &amp; Parts</option>
                                <option value="75">- - - - Cables &amp; Adapters</option>
                                <option value="76">- - - - Batteries</option>
                                <option value="77">- - - - Chargers</option>
                                <option value="78">- - - - Bags &amp; Cases</option>
                                <option value="79">- - - - Electronic Cigarettes</option>
                                <option value="70">- - Audio &amp; Video</option>
                                <option value="80">- - - - Televisions</option>
                                <option value="81">- - - - TV Receivers</option>
                                <option value="82">- - - - Projectors</option>
                                <option value="83">- - - - Audio Amplifier Boards</option>
                                <option value="84">- - - - TV Sticks</option>
                                <option value="71">- - Camera &amp; Photo</option>
                                <option value="85">- - - - Digital Cameras</option>
                                <option value="86">- - - - Camcorders</option>
                                <option value="87">- - - - Camera Drones</option>
                                <option value="88">- - - - Action Cameras</option>
                                <option value="89">- - - - Photo Studio Supplies</option>
                                <option value="72">- - Portable Audio &amp; Video</option>
                                <option value="90">- - - - Headphones</option>
                                <option value="91">- - - - Speakers</option>
                                <option value="92">- - - - MP3 Players</option>
                                <option value="93">- - - - VR/AR Devices</option>
                                <option value="94">- - - - Microphones</option>
                                <option value="73">- - Smart Electronics</option>
                                <option value="95">- - - - Wearable Devices</option>
                                <option value="96">- - - - Smart Home Appliances</option>
                                <option value="97">- - - - Smart Remote Controls</option>
                                <option value="98">- - - - Smart Watches</option>
                                <option value="99">- - - - Smart Wristbands</option>
                                <option value="74">- - Video Games</option>
                                <option value="100">- - - - Handheld Game Players</option>
                                <option value="101">- - - - Game Controllers</option>
                                <option value="102">- - - - Joysticks</option>
                                <option value="103">- - - - Stickers</option>
                                <option value="104">Game Consoles</option>
                                <option value="105">Mp3 &amp; headphone</option>
                                <option value="106">Tv &amp; Video</option>
                                <option value="107">Watches</option>
                                <option value="108">Washing Machine</option>
                                <option value="109">Camera</option>
                                <option value="110">Audio &amp; Theater</option>
                                <option value="111">Accessories</option>
                                <option value="112">Games &amp; Consoles</option>
                            </select>
                        </div>
                        <input type="text" placeholder="Enter your search key ... " />
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
                        <button class="category-toggle"><i class="fa fa-bars"></i> All Categories</button>
                    </div>

                    <!-- Category Menu -->
                    <nav class="category-menu">
                        <ul>
                            <li><a href="#">Televisions</a></li>
                            <li class="menu-item-has-children menu-item-has-children-1">
                                <a href="#">Accessories & Parts<i class="ion-ios-arrow-down"></i></a>
                                <!-- category submenu -->
                                <ul class="category-mega-menu category-mega-menu-1">
                                    <li><a href="#">Cables & Adapters</a></li>
                                    <li><a href="#">Batteries</a></li>
                                    <li><a href="#">Chargers</a></li>
                                    <li><a href="#">Bags & Cases</a></li>
                                    <li><a href="#">Electronic Cigarettes</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children menu-item-has-children-2">
                                <a href="#">Camera & Photo<i class="ion-ios-arrow-down"></i></a>
                                <!-- category submenu -->
                                <ul class="category-mega-menu category-mega-menu-2">
                                    <li><a href="#">Digital Cameras</a></li>
                                    <li><a href="#">Camcorders</a></li>
                                    <li><a href="#">Camera Drones</a></li>
                                    <li><a href="#">Action Cameras</a></li>
                                    <li><a href="#">Photo Studio Supplies</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children menu-item-has-children-3">
                                <a href="#">Smart Electronics <i class="ion-ios-arrow-down"></i></a>
                                <!-- category submenu -->
                                <ul class="category-mega-menu category-mega-menu-3">
                                    <li><a href="#">Wearable Devices</a></li>
                                    <li><a href="#">Smart Home Appliances</a></li>
                                    <li><a href="#">Smart Remote Controls</a></li>
                                    <li><a href="#">Smart Watches</a></li>
                                    <li><a href="#">Smart Wristbands</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children menu-item-has-children-4">
                                <a href="#">Audio & Video <i class="ion-ios-arrow-down"></i></a>
                                <!-- category submenu -->
                                <ul class="category-mega-menu category-mega-menu-4">
                                    <li><a href="#">Televisions</a></li>
                                    <li><a href="#">TV Receivers</a></li>
                                    <li><a href="#">Projectors</a></li>
                                    <li><a href="#">Audio Amplifier Boards</a></li>
                                    <li><a href="#">TV Sticks</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children menu-item-has-children-6">
                                <a href="#">Video Game <i class="ion-ios-arrow-down"></i></a>
                                <!-- category submenu -->
                                <ul class="category-mega-menu category-mega-menu-6">
                                    <li><a href="#">Handheld Game Players</a></li>
                                    <li><a href="#">Game Controllers</a></li>
                                    <li><a href="#">Joysticks</a></li>
                                    <li><a href="#">Stickers</a></li>
                                </ul>
                            </li>
                            <li class="menu-item"><a href="#">Digital Cameras</a></li>
                            <li class="menu-item"><a href="#">Headphones</a></li>
                            <li class="menu-item"><a href="#"> Wearable Devices</a></li>
                            <li class="menu-item"><a href="#"> Smart Watches</a></li>
                            <li class="menu-item"><a href="#"> Game Controllers</a></li>
                            <li class="menu-item"><a href="#"> Smart Home Appliances</a></li>
                            <li class="hidden"><a href="#">Projectors</a></li>
                            <li>
                                <a href="#" id="more-btn"><i class="ion-ios-plus-empty" aria-hidden="true"></i> More Categories</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!--=======  End of category menu =======-->
            </div>
        </div>
    </div>
</div>
<!-- Mobile Header Section End -->
<!-- OffCanvas Wishlist Start -->
<div id="offcanvas-wishlist" class="offcanvas offcanvas-wishlist">
    <div class="inner">
        <div class="head">
            <span class="title">Wishlist</span>
            <button class="offcanvas-close">×</button>
        </div>
        <div class="body customScroll">
            <ul class="minicart-product-list">
                <li>
                    <a href="single-product.html" class="image"><img src="images/product-image/1.jpg" alt="Cart product Image"></a>
                    <div class="content">
                        <a href="single-product.html" class="title">Walnut Cutting Board</a>
                        <span class="quantity-price">1 x <span class="amount">$100.00</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="single-product.html" class="image"><img src="images/product-image/2.jpg" alt="Cart product Image"></a>
                    <div class="content">
                        <a href="single-product.html" class="title">Lucky Wooden Elephant</a>
                        <span class="quantity-price">1 x <span class="amount">$35.00</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="single-product.html" class="image"><img src="images/product-image/3.jpg" alt="Cart product Image"></a>
                    <div class="content">
                        <a href="single-product.html" class="title">Fish Cut Out Set</a>
                        <span class="quantity-price">1 x <span class="amount">$9.00</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="foot">
            <div class="buttons">
                <a href="wishlist.html" class="btn btn-dark btn-hover-primary mt-30px">view wishlist</a>
            </div>
        </div>
    </div>
</div>
<!-- OffCanvas Wishlist End -->

<!-- OffCanvas Cart Start -->
<div id="offcanvas-cart" class="offcanvas offcanvas-cart">
    <div class="inner">
        <div class="head">
            <span class="title">Cart</span>
            <button class="offcanvas-close">×</button>
        </div>
        <div class="body customScroll">
            <ul class="minicart-product-list">
                <li>
                    <a href="single-product.html" class="image"><img src="images/product-image/1.jpg" alt="Cart product Image"></a>
                    <div class="content">
                        <a href="single-product.html" class="title">Walnut Cutting Board</a>
                        <span class="quantity-price">1 x <span class="amount">$100.00</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="single-product.html" class="image"><img src="images/product-image/2.jpg" alt="Cart product Image"></a>
                    <div class="content">
                        <a href="single-product.html" class="title">Lucky Wooden Elephant</a>
                        <span class="quantity-price">1 x <span class="amount">$35.00</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="single-product.html" class="image"><img src="images/product-image/3.jpg" alt="Cart product Image"></a>
                    <div class="content">
                        <a href="single-product.html" class="title">Fish Cut Out Set</a>
                        <span class="quantity-price">1 x <span class="amount">$9.00</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="foot">
            <div class="sub-total">
                <strong>Subtotal :</strong>
                <span class="amount">$144.00</span>
            </div>
            <div class="buttons">
                <a href="cart.html" class="btn btn-dark btn-hover-primary mb-30px">view cart</a>
                <a href="checkout.html" class="btn btn-outline-dark current-btn">checkout</a>
            </div>
            <p class="minicart-message">Free Shipping on All Orders Over $100!</p>
        </div>
    </div>
</div>
<!-- OffCanvas Cart End -->

<!-- OffCanvas Search Start -->
<div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
    <div class="inner customScroll">
        <div class="head">
            <span class="title">&nbsp;</span>
            <button class="offcanvas-close">×</button>
        </div>
        <div class="offcanvas-menu-search-form">
            <form action="#">
                <input type="text" placeholder="Search...">
                <button><i class="lnr lnr-magnifier"></i></button>
            </form>
        </div>
        <div class="offcanvas-menu">
            <ul>
                <li><a href="#"><span class="menu-text">Home</span></a>
                    <ul class="sub-menu">
                        <li><a href="index.html"><span class="menu-text">Home 1</span></a></li>
                        <li><a href="index-2.html"><span class="menu-text">Home 2</span></a></li>
                        <li> <a href="index-3.html"><span class="menu-text">Home 3</span></a></li>
                        <li><a href="index-4.html"><span class="menu-text">Home 4</span></a></li>
                    </ul>
                </li>
                <li><a href="#"><span class="menu-text">Shop</span></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="#"><span class="menu-text">Shop Grid</span></a>
                            <ul class="sub-menu">
                                <li><a href="shop-3-column.html">Shop Grid 3 Column</a></li>
                                <li><a href="shop-4-column.html">Shop Grid 4 Column</a></li>
                                <li><a href="shop-left-sidebar.html">Shop Grid Left Sidebar</a></li>
                                <li><a href="shop-right-sidebar.html">Shop Grid Right Sidebar</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span class="menu-text">Shop List</span></a>
                            <ul class="sub-menu">
                                <li><a href="shop-list.html">Shop List</a></li>
                                <li><a href="shop-list-left-sidebar.html">Shop List Left Sidebar</a></li>
                                <li><a href="shop-list-right-sidebar.html">Shop List Right Sidebar</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span class="menu-text">Shop Single</span></a>
                            <ul class="sub-menu">
                                <li><a href="single-product.html">Shop Single</a></li>
                                <li><a href="single-product-variable.html">Shop Variable</a></li>
                                <li><a href="single-product-affiliate.html">Shop Affiliate</a></li>
                                <li><a href="single-product-group.html">Shop Group</a></li>
                                <li><a href="single-product-tabstyle-2.html">Shop Tab 2</a></li>
                                <li><a href="single-product-tabstyle-3.html">Shop Tab 3</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span class="menu-text">Shop Single</span></a>
                            <ul class="sub-menu">
                                <li><a href="single-product-slider.html">Shop Slider</a></li>
                                <li><a href="single-product-gallery-left.html">Shop Gallery Left</a></li>
                                <li><a href="single-product-gallery-right.html">Shop Gallery Right</a></li>
                                <li><a href="single-product-sticky-left.html">Shop Sticky Left</a></li>
                                <li><a href="single-product-sticky-right.html">Shop Sticky Right</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="#"><span class="menu-text">Pages</span></a>
                    <ul class="sub-menu">
                        <li><a href="about.html">About Page</a></li>
                        <li><a href="cart.html">Cart Page</a></li>
                        <li><a href="checkout.html">Checkout Page</a></li>
                        <li><a href="compare.html">Compare Page</a></li>
                        <li><a href="login.html">Login & Register Page</a></li>
                        <li><a href="my-account.html">Account Page</a></li>
                        <li><a href="empty-cart.html">Empty Cart Page</a></li>
                        <li><a href="404.html">404 Page</a></li>
                        <li><a href="wishlist.html">Wishlist Page</a></li>
                    </ul>
                </li>
                <li><a href="#"><span class="menu-text">Blog</span></a>
                    <ul class="sub-menu">
                        <li><a href="#"><span class="menu-text">Blog Grid</span></a>
                            <ul class="sub-menu">
                                <li><a href="blog-grid-left-sidebar.html">Blog Grid Left Sidebar</a></li>
                                <li><a href="blog-grid-right-sidebar.html">Blog Grid Right Sidebar</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><span class="menu-text">Blog List</span></a>
                            <ul class="sub-menu">
                                <li><a href="blog-list-left-sidebar.html">Blog List Left Sidebar</a></li>
                                <li><a href="blog-list-right-sidebar.html">Blog List Right Sidebar</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><span class="menu-text">Blog Single</span></a>
                            <ul class="sub-menu">
                                <li><a href="blog-single-left-sidebar.html">Blog Single Left Sidebar</a></li>
                                <li><a href="blog-single-right-sidebar.html">Blog Single Right Sidbar</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="#"><span class="menu-text">Custom Menu</span></a>
                    <ul class="sub-menu">
                        <li><a href="shop-4-column.html">Women Is Clothes & Fashion</a></li>
                        <li><a href="shop-4-column.html">Simple Style</a></li>
                        <li><a href="shop-4-column.html">Easy Style</a></li>
                    </ul>
                </li>
                <li><a href="contact.html">Contact Us</a></li>
            </ul>
        </div>
        <!-- OffCanvas Menu End -->
        <div class="offcanvas-social mt-30px">
            <ul>
                <li>
                    <a href="#"><i class="ion-social-facebook"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ion-social-twitter"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ion-social-google"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ion-social-youtube"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ion-social-instagram"></i></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- OffCanvas Search End -->

<div class="offcanvas-overlay"></div>



<div class="container">
    @yield('content')
</div>





<!-- Brand area start -->
<div class="brand-area mt-30px mb-50px">
    <div class="container">
        <div class="brand-slider">
            <div class="brand-slider-item">
                <a href="#"><img class=" img-responsive" src="images/brand-logo/1.jpg" alt="" /></a>
            </div>
            <div class="brand-slider-item">
                <a href="#"><img class=" img-responsive" src="images/brand-logo/2.jpg" alt="" /></a>
            </div>
            <div class="brand-slider-item">
                <a href="#"><img class=" img-responsive" src="images/brand-logo/3.jpg" alt="" /></a>
            </div>
            <div class="brand-slider-item">
                <a href="#"><img class=" img-responsive" src="images/brand-logo/4.jpg" alt="" /></a>
            </div>
            <div class="brand-slider-item">
                <a href="#"><img class=" img-responsive" src="images/brand-logo/5.jpg" alt="" /></a>
            </div>
            <div class="brand-slider-item">
                <a href="#"><img class=" img-responsive" src="images/brand-logo/1.jpg" alt="" /></a>
            </div>
            <div class="brand-slider-item">
                <a href="#"><img class=" img-responsive" src="images/brand-logo/2.jpg" alt="" /></a>
            </div>
        </div>
    </div>
</div>
<!-- Brand area end -->


<!-- Footer Area Start -->
<div class="footer-area">
    <div class="footer-container">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-md-30px mb-lm-30px">
                        <div class="single-wedge">
                            <div class="footer-logo">
                                <a href="index.html"><img class="img-responsive" src="images/logo/logo.jpg" alt="logo.jpg" /></a>
                            </div>
                            <p class="text-infor">We are a team of designers and developers that create high quality HTML template</p>
                            <div class="need_help">
                                <p class="add"><span class="address">Address:</span> 4710-4890 Breckinridge St, Fayetteville</p>
                                <p class="mail"><span class="email">Email:</span> <a href="mailto:support@hasthemes.com">support@hasthemes.com</a></p>
                                <p class="phone"><span class="call us">Call Us:</span> <a href="tel:(+800)123456789"> (+800)123456789</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 col-sm-6 mb-md-30px mb-lm-30px">
                        <div class="single-wedge">
                            <h4 class="footer-herading">Information</h4>
                            <div class="footer-links">
                                <ul>
                                    <li><a href="#">Delivery</a></li>
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="#">Secure Payment</a></li>
                                    <li><a href="contact.html">Contact Us</a></li>
                                    <li><a href="#">Sitemap</a></li>
                                    <li><a href="#">Stores</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 col-sm-6 mb-sm-30px mb-lm-30px">
                        <div class="single-wedge">
                            <h4 class="footer-herading">CUSTOM LINKS</h4>
                            <div class="footer-links">
                                <ul>
                                    <li><a href="#">Legal Notice</a></li>
                                    <li><a href="#">Prices Drop</a></li>
                                    <li><a href="#">New Products</a></li>
                                    <li><a href="#">Best Sales</a></li>
                                    <li><a href="login.html">Login</a></li>
                                    <li><a href="my-account.html">My Account</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 ">
                        <div class="single-wedge">
                            <h4 class="footer-herading">From Our Blog</h4>
                            <div class="footer-blog-slider">
                                <div class="footer-blog-slider-wrapper slider-nav-style-3 ">
                                    <!-- Single-item -->
                                    <div class="single-slider-item">
                                        <div class="footer-blog-post d-flex mb-30px">
                                            <div class="footer-blog-post-top">
                                                <div class="post-thumbnail">
                                                    <a href="blog-single-left-sidebar.html">
                                                        <img src="images/blog-image/blog-8.jpg" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="footer-blog-content">
                                                <h4><a href="blog-single-left-sidebar.html">This is First Post For XipBlog</a></h4>
                                                <div class="footer-blog-meta">
                                                    <span class="autor">Posted by <a href="#">Demo Hasthemes</a> </span>
                                                    <span class="date">Jun 29,2020</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="footer-blog-post">
                                            <div class="footer-blog-post-top">
                                                <div class="post-thumbnail">
                                                    <a href="blog-single-left-sidebar.html">
                                                        <img src="images/blog-image/blog-9.jpg" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="footer-blog-content">
                                                <h4><a href="blog-single-left-sidebar.html">This is Secound Post For XipBlog</a></h4>
                                                <div class="footer-blog-meta">
                                                    <span class="autor">Posted by <a href="#">Demo Hasthemes</a> </span>
                                                    <span class="date">Jun 29,2020</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single-item -->
                                    <div class="single-slider-item">
                                        <div class="footer-blog-post d-flex mb-30px">
                                            <div class="footer-blog-post-top">
                                                <div class="post-thumbnail">
                                                    <a href="blog-single-left-sidebar.html">
                                                        <img src="images/blog-image/blog-10.jpg" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="footer-blog-content">
                                                <h4><a href="blog-single-left-sidebar.html">This is Third Post For XipBlog</a></h4>
                                                <div class="footer-blog-meta">
                                                    <span class="autor">Posted by <a href="#">Demo Hasthemes</a> </span>
                                                    <span class="date">Jun 29,2020</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="footer-blog-post d-flex">
                                            <div class="footer-blog-post-top">
                                                <div class="post-thumbnail">
                                                    <a href="blog-single-left-sidebar.html">
                                                        <img src="images/blog-image/blog-11.jpg" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="footer-blog-content">
                                                <h4><a href="blog-single-left-sidebar.html">This is Fourth Post For XipBlog</a></h4>
                                                <div class="footer-blog-meta">
                                                    <span class="autor">Posted by <a href="#">Demo Hasthemes</a> </span>
                                                    <span class="date">Jun 29,2020</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single-item end -->
                                </div>
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
                        <div class="footer-paymet-warp d-flex">
                            <div class="heading-info">Payment:</div>
                            <div class="payment-way"><img class="payment-img img-responsive" src="images/icons/payment.png" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-social-icon d-flex">
                            <div class="heading-info">Follow Us:</div>
                            <div class="social-icon">
                                <ul>
                                    <li class="facebook">
                                        <a href="#"><i class="ion-social-facebook"></i></a>
                                    </li>
                                    <li class="twitter">
                                        <a href="#"><i class="ion-social-twitter"></i></a>
                                    </li>
                                    <li class="google">
                                        <a href="#"><i class="ion-social-google"></i></a>
                                    </li>
                                    <li class="youtube">
                                        <a href="#"><i class="ion-social-youtube"></i></a>
                                    </li>
                                    <li class="instagram">
                                        <a href="#"><i class="ion-social-instagram"></i></a>
                                    </li>
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
                    <div class="col-md-12">
                        <div class="tag-content">
                            <ul>
                                <li><a href="#">Online Shopping</a></li>
                                <li><a href="#">Promotions</a></li>
                                <li><a href="#">My Orders</a></li>
                                <li><a href="#">Help</a></li>
                                <li><a href="#">Customer Service</a></li>
                                <li><a href="#">Support</a></li>
                                <li><a href="#">Most Populars</a></li>
                                <li><a href="#">New Arrivals</a></li>
                                <li><a href="#">Special Products</a></li>
                                <li><a href="#">Manufacturers</a></li>
                                <li><a href="#">Our Stores</a></li>
                                <li><a href="#">Shipping</a></li>
                                <li><a href="#">Payments</a></li>
                                <li><a href="#">Warantee</a></li>
                                <li><a href="#">Refunds</a></li>
                                <li><a href="#">Checkout</a></li>
                                <li><a href="#">Discount</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <p class="copy-text">Copyright © <a href="https://hasthemes.com/"> HasThemes</a>. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer Area End -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 mb-lm-100px mb-sm-30px">
                        <div class="quickview-wrapper">
                            <!-- slider -->
                            <div class="gallery-top">
                                <div class="single-slide">
                                    <img class="img-responsive m-auto" src="images/product-image/8.jpg" alt="">
                                </div>
                                <div class="single-slide">
                                    <img class="img-responsive m-auto" src="images/product-image/14.jpg" alt="">
                                </div>
                                <div class="single-slide">
                                    <img class="img-responsive m-auto" src="images/product-image/15.jpg" alt="">
                                </div>
                                <div class="single-slide">
                                    <img class="img-responsive m-auto" src="images/product-image/11.jpg" alt="">
                                </div>
                                <div class="single-slide">
                                    <img class="img-responsive m-auto" src="images/product-image/19.jpg" alt="">
                                </div>
                            </div>
                            <div class=" gallery-thumbs">
                                <div class="single-slide">
                                    <img class="img-responsive m-auto" src="images/product-image/8.jpg" alt="">
                                </div>
                                <div class="single-slide">
                                    <img class="img-responsive m-auto" src="images/product-image/14.jpg" alt="">
                                </div>
                                <div class="single-slide">
                                    <img class="img-responsive m-auto" src="images/product-image/15.jpg" alt="">
                                </div>
                                <div class="single-slide">
                                    <img class="img-responsive m-auto" src="images/product-image/11.jpg" alt="">
                                </div>
                                <div class="single-slide">
                                    <img class="img-responsive m-auto" src="images/product-image/19.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="product-details-content quickview-content">
                            <h2>Originals Kaval Windbr</h2>
                            <p class="reference">Reference:<span> demo_17</span></p>
                            <div class="pro-details-rating-wrap">
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                                <span class="read-review"><a class="reviews" href="#">Read reviews (1)</a></span>
                            </div>
                            <div class="pricing-meta">
                                <ul>
                                    <li class="old-price not-cut">€18.90</li>
                                </ul>
                            </div>
                            <p class="quickview-para">Lorem ipsum dolor sit amet, consectetur adipisic elit eiusm tempor incidid ut labore et dolore magna aliqua. Ut enim ad minim venialo quis nostrud exercitation ullamco</p>
                            <div class="pro-details-size-color">
                                <div class="pro-details-color-wrap">
                                    <span>Color</span>
                                    <div class="pro-details-color-content">
                                        <ul>
                                            <li class="blue"></li>
                                            <li class="maroon active"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="pro-details-quality">
                                <div class="cart-plus-minus">
                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1" />
                                </div>
                                <div class="pro-details-cart btn-hover">
                                    <a href="#"> + Add To Cart</a>
                                </div>
                            </div>
                            <div class="pro-details-wish-com">
                                <div class="pro-details-wishlist">
                                    <a href="wishlist.html"><i class="ion-android-favorite-outline"></i>Add to wishlist</a>
                                </div>
                                <div class="pro-details-compare">
                                    <a href="compare.html"><i class="ion-ios-shuffle-strong"></i>Add to compare</a>
                                </div>
                            </div>
                            <div class="pro-details-social-info">
                                <span>Share</span>
                                <div class="social-info">
                                    <ul>
                                        <li>
                                            <a href="#"><i class="ion-social-facebook"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-social-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-social-google"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-social-instagram"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->
<!-- JS
============================================ -->

<!-- Vendors JS -->
<script src="{{asset('js/vendor/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/vendor/jquery-migrate-3.3.0.min.js')}}"></script>
<script src="{{asset('js/vendor/modernizr-3.7.1.min.js')}}"></script>

<!-- Plugins JS -->
<script src="{{asset('js/plugins/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/plugins/slick.js')}}"></script>
<script src="{{asset('js/plugins/countdown.js')}}"></script>
<script src="{{asset('js/plugins/scrollup.js')}}"></script>
<script src="{{asset('js/plugins/elevateZoom.js')}}"></script>

<!-- Use the minified version files listed below for better performance and remove the files listed above -->
<!-- <script src="assets/js/vendor/vendor.min.js"></script>
        <script src="assets/js/plugins/plugins.min.js"></script> -->

<!-- Main Activation JS -->
<script src="{{asset('js/main.js')}}"></script>
<!-- Section para agregar csrf token a todas las llamadas ajax de jquery -->
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@yield('footer_scripts')
</body>
</html>
