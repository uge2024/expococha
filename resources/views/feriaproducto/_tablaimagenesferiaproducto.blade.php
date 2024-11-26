        <h5>Puede subir un maximo de {{$limiteImagen}} imagenes por producto</h5>
        <input type="hidden" value="{{$cantidadimageneshay}}" id="cantidadimageneshay" name="cantidadimageneshay">
        <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>  <center>Imagenes banner de 600 x 600 px</center> </th>
                                                <th width="8%"> </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $indice = 1;
                                            @endphp
                                            @foreach ($imagen_productos as $item)
                                                <tr>
                                                    <td>
                                                        {{$indice++}}
                                                    </td>
                                                    <td><center>
                                                        {{
                                                            Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen_icono', 'class' =>'img-thumbnail','width'=>'140'))
                                                        }}</center>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarImagen('{{$item->ipf_id}}','{{$item->fpr_id}}','{{$item->numero_imagen}}');"><i class="fa fa-trash"></i> </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table><br>
