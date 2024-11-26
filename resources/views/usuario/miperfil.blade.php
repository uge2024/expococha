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
                            <li>Mi Perfil</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <!-- account area start -->
    <div class="checkout-area mtb-50px">
        <div class="container">
            <div class="row">
                <div class="ml-auto mr-auto col-lg-9">
                    <div class="checkout-wrapper">
                        <div id="faq" class="panel-group">
                            <div class="panel panel-default single-my-account">
                                <div class="panel-heading my-account-title">
                                    <h3 class="panel-title"><span>1 .</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Editar mi datos </a></h3>
                                </div>
                                <div id="my-account-1" class="panel-collapse collapse show">
                                    <div class="panel-body">
                                        <form id="formDatos" method="post" action="{{url('usuario/perfilstoredatos')}}">
                                            @csrf
                                            <input type="hidden" id="id" name="id" value="{{$user->id}}">
                                            <div class="myaccount-info-wrapper">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Nombre Completo*</label>
                                                            <input type="text" value="{{$user->name}}" name="name" id="name" required autofocus/>
                                                            @error('name')
                                                                <p class="form-text text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Celular*</label>
                                                            <input type="text" value="{{$user->celular}}" name="celular" id="celular" required autofocus/>
                                                            @error('celular')
                                                            <p class="form-text text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Dirección*</label>
                                                            <input type="text" value="{{$user->direccion}}" name="direccion" id="direccion" required autofocus/>
                                                            @error('direccion')
                                                            <p class="form-text text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Correo Electrónico*</label>
                                                            <input type="email" value="{{$user->email}}" class="form-control" name="email" id="email" required readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">

                                                    </div>
                                                </div>
                                                <div class="billing-back-btn">
                                                    <div class="billing-back">
                                                        {{--<a href="#"><i class="fa fa-arrow-up"></i> back</a>--}}
                                                    </div>
                                                    <div class="billing-btn">
                                                        <button type="submit" id="btnSubmitDatos">Guardar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default single-my-account">
                                <div class="panel-heading my-account-title">
                                    <h3 class="panel-title"><span>2 .</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Modificar Mi Contraseña </a></h3>
                                </div>
                                <div id="my-account-2" class="panel-collapse collapse show">
                                    <div class="panel-body">
                                        <form id="formContrasenia" method="post" action="{{url('usuario/perfilstorecontrasenia')}}">
                                            @csrf
                                            <input type="hidden" id="id" name="id" value="{{$user->id}}">
                                            <div class="myaccount-info-wrapper">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Contraseña*</label>
                                                            <input type="password" name="password" id="password" required autofocus/>
                                                        </div>
                                                        @error('password')
                                                            <p class="form-text text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>Confirmar Contraseña*</label>
                                                            <input type="password" id="password_confirmation" name="password_confirmation" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="billing-back-btn">
                                                    <div class="billing-back">
                                                        {{--<a href="#"><i class="fa fa-arrow-up"></i> back</a>--}}
                                                    </div>
                                                    <div class="billing-btn">
                                                        <button type="submit" id="btnSubmitContrasenia">Guardar</button>
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
    <!-- account area end -->
@endsection
@section('footer_scripts')

    <script>
        $(document).ready(function(){
            validarInputEntero($("#celular"));
            $("#formRegister").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@stop
