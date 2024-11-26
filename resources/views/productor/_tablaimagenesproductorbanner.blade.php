                                    <h5>Puede subir un maximo de {{$limiteImagen}} imagenes por producto</h5>
                                    <input type="hidden" value="{{$cantidadimagenesbannerhay}}" id="cantidadimagenesbannerhay" name="cantidadimagenesbannerhay">
                                    <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th><center>Imagenes banner de 1920 x 480 px</center></th>
                                            <th width="8%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $indice = 1;
                                        @endphp
                                        @foreach ($imagenesBanners as $item)
                                            <tr>
                                                <td>
                                                    {{$indice++}}
                                                </td>
                                                <td>
                                                    {{
                                                        Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen_icono', 'class' =>'img-thumbnail'))
                                                    }}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarImagenBanner('{{$item->ipd_id}}','{{$item->imagen}}');"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table><br>
