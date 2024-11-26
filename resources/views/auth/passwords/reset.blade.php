@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('content')
    <!-- reset contrasenia area start -->
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
                                        <form method="POST" action="{{ route('password.update') }}">
                                            @csrf

                                            <input type="hidden" name="token" value="{{ $token }}">

                                            <input type="email" id="email" name="email" placeholder="Correo Electronico" class=" @error('email') is-invalid @enderror " value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus />
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <input type="password" id="password" name="password" placeholder="Contraseña" class=" @error('password') is-invalid @enderror " required autocomplete="new-password" />
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña" required autocomplete="new-password" />

                                            <div class="button-box">
                                                <button type="submit"><span>Restablecer Contraseña</span></button>
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
    <!-- reset contrasenia area end -->
@endsection
