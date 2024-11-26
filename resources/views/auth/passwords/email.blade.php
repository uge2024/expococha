@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('content')

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{url('/')}}">Inicio</a></li>
                            <li>Restablecer Contraseña</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <!-- restablecer contrasenia area start -->
    <div class="login-register-area mb-50px mt-40px">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#lg1">
                                <h4>Restablecer Contraseña</h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        <form id="formEmail" method="POST" action="{{ route('password.email') }}">
                                            @csrf
                                            <input type="email" id="email" name="email" placeholder="Correo Electronico" class=" @error('email') is-invalid @enderror " value="{{ old('email') }}" required autocomplete="email" autofocus />
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="button-box">
                                                <button id="btn_email" type="submit"><span>Enviar enlace para Restablecer Contraseña</span></button>
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
    <!-- restablecer contrasenia area end -->

@endsection
@section('footer_scripts')

    <script>
        $(document).ready(function(){
            $("#formEmail").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@stop
