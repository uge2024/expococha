@php
    $meu_id = 0;
@endphp
@foreach($mensajes as $key=>$mensaje)
    @php
        $meu_id = $mensaje->meu_id;
    @endphp
    @if($mensaje->usr_id_r == $user->id)
        <div class="container-mensaje" id="divmen-{{$mensaje->meu_id}}">
            <p class="persona-left"><b>{{$mensaje->usuarioEnvia->name}}</b></p>
            <p>{{$mensaje->mensaje}}</p>
            <span class="time-right">{{date('d/m/Y H:i:s',strtotime($mensaje->fecha))}}
                            <br>
                            {{--<p id="visto-{{$mensaje->meu_id}}">Visto</p>--}}
                        </span>
        </div>
    @else
        <div class="container-mensaje darker" id="divmen-{{$mensaje->meu_id}}">
            <p class="persona-right"><b>{{$mensaje->usuarioEnvia->name}}</b></p>
            <p class="text-lg-right">{{$mensaje->mensaje}}</p>
            <span class="time-left">{{date('d/m/Y H:i:s',strtotime($mensaje->fecha))}}
                            <br>
                            @if($mensaje->visto == 0)
                    <p class="miclasevisto" id="visto-{{$mensaje->meu_id}}">Enviado</p>
                @else
                    <p class="miclasevisto" id="visto-{{$mensaje->meu_id}}">Visto</p>
                @endif
                        </span>
        </div>
    @endif
@endforeach
