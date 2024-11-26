@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('content')

    <!-- restablecer contrasenia area start -->
    <div class="login-register-area mb-50px mt-40px">
        <div class="container">
            <div class="alert alert-success text-center">
                @if($todoOk == true)
                    <h3>{{$mensaje}}</h3>
                    <a href="{{url('/')}}" class="btn btn-primary">Visitar la Página Web</a>
                @else
                    <h3>{{$mensaje}}</h3>
                @endif
            </div>
        </div>
    </div>
    <!-- restablecer contrasenia area end -->

@endsection
@section('footer_scripts')

    <script>
        $(document).ready(function(){

        });
    </script>
@stop
