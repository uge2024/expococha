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
                            <li>Ingresar</li>
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
                            <a class="active" data-toggle="tab" href="#lg1">
                                <h4>Ingresar</h4>
                            </a>
                            {{--<a data-toggle="tab" href="#lg2">
                                <h4>Registrarse</h4>
                            </a>--}}
                        </div>
                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <input type="email" id="email" name="email" placeholder="Correo Electronico" class=" @error('email') is-invalid @enderror " value="{{ old('email') }}" required autocomplete="email" autofocus />
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <input type="password" id="password" name="password" placeholder="Contraseña" class=" @error('password') is-invalid @enderror " required autocomplete="current-password" />
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <div class="button-box">
                                                <div class="login-toggle-btn">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember">
                                                        Recuerdame
                                                    </label>
                                                    @if (Route::has('password.request'))
                                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                                            ¿Olvido su Contraseña?
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="row m-2 col-md-12">
                                                    <div class="col-md-6">
                                                        <button class="m-1" type="submit"><span>Ingresar</span></button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button class="m-1" onclick=" window.open('{{url('register')}}','_self'); " type="button"><span>Registrarse</span></button>
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
    <!-- login area end -->
@endsection
