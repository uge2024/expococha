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
                            <li>Registrarse</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <!-- login area start -->
    <div class="login-register-area mb-50px mt-40px">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#lg2">
                                <h4>Registrarse</h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg2" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form id="formRegister" method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <input id="name" type="text" data-toggle="tooltip" data-placement="bottom" title="Nombre Completo" placeholder="Nombre Completo" class=" @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <input id="email" type="email" data-toggle="tooltip" data-placement="bottom" title="Correo Electrónico" placeholder="Correo Electrónico" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <input id="celular" type="text" data-toggle="tooltip" data-placement="bottom" title="Celular" placeholder="Celular" class=" @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular') }}" required autocomplete="celular">
                                            @error('celular')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <input id="direccion" type="text" data-toggle="tooltip" data-placement="bottom" title="Dirección" placeholder="Dirección" class=" @error('direccion') is-invalid @enderror" name="direccion" value="{{ old('direccion') }}" required autocomplete="direccion">
                                            @error('direccion')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <input id="password" type="password" data-toggle="tooltip" data-placement="bottom" title="Contraseña" placeholder="Contraseña" class=" @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <input id="password-confirm" type="password" data-toggle="tooltip" data-placement="bottom" title="Confirmar Contraseña" placeholder="Confirmar Contraseña" name="password_confirmation" required autocomplete="new-password">

                                            <div class="button-box">
                                                <button type="submit" id="btnRegistrarme"><span>Registrarme</span></button>
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
        <br><br><br><br>
    </div>
    <!-- login area end -->
@endsection
@section('footer_scripts')

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(document).ready(function(){
            validarInputEntero($("#celular"));
            $("#formRegister").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@stop
