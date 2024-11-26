@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    {{--<div class="container">
        <h1>This is a Heading</h1>
        <p>This is a paragraph.</p>



        @foreach($lista as $item)
            <li>{{$item->titulo}}</li>
            <li>{{$loop->count}}</li>
        @endforeach
    </div>--}}
    {{--<br>
    <h3>sssss</h3>
    <p>{{$encriptado}}</p>
    <br>
    <p>{{$desencriptado}}</p>
    <br>
    <p>{{$horas}}</p>
    <br>
    <p>{{$esCorreoIgual}}</p>
    <br>
    <p>{{asset('storage/uploads/')}}</p>
    <p>160408471420190508210527000000logo.png</p>
    <img src="{{asset('storage/uploads/'.'160408471420190508210527000000logo.png22')}}" alt="sin imagen">--}}

    <div class="container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>dd</th>
                    <th>uno</th>
                    <th>uno</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lista as $li)
                    <tr>
                        <td>{{$li->pos_id}}</td>
                        <td>{{$li->titulo}}</td>
                        <td>{{$li->descripcion}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{--<p>{{$lista->onEachSide(3)}}</p>--}}
        <div class="d-flex justify-content-center">
            {{ $lista->appends(['ordenar'=>'1'])->links() }}
        </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">

    </script>
@endsection
