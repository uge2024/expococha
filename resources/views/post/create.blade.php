@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('header_styles')
    <link rel="stylesheet" href="{{asset('css/summernote-bs4.min.css')}}">
    <style type="text/css">
        .dropzone {
            background-color: #ccc;
            border: 3px dashed #888;
            width: 350px;
            height: 150px;
            border-radius: 25px;
            font-size: 20px;
            color: #777;
            padding-top: 50px;
            text-align: center;
        }
        .dropzone.over {
            opacity: .7;
            border-style: solid;
        }
        #dropzone .dropzone {
            margin-top: 25px;
            padding-top: 60px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <h2>HTML Forms</h2>
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach

        <form action="{{url('/post')}}" method="post" enctype="multipart/form-data">
            @csrf
            <label for="titulo">titulo</label>
            <input type="text" id="titulo" name="titulo" value="John"><br>

            <label for="descripcion">descripcion</label>
            {{--<input type="text" id="descripcion" name="descripcion" value="Doe"><br>--}}
            <textarea id="descripcion" name="descripcion"></textarea>

            <label for="fecha">fecha</label>
            <input type="text" id="fecha" name="fecha" value="{{date('Y-m-d')}}"><br>
            <input type="text" id="fecha_dos" name="fecha_dos" value="{{date('d/m/Y')}}"><br>

            <label for="bandera">bandera</label>
            <input type="checkbox" name="bandera" id="bandera" value="false"><br>

            <label for="valor_a">valor a</label>
            <input type="number" id="valor_a" name="valor_a" value="12.2"><br>

            <label for="valor_b">valor b</label>
            <input type="number" id="valor_b" name="valor_b" value="12.2"><br>

            <label for="valor_c">valor c</label>
            <input type="number" id="valor_c" name="valor_c" value="12.2"><br>

            <label for="valor_d">valor d</label>
            <input type="number" id="valor_d" name="valor_d" value="12"><br>

            <label for="fecha_hora">fecha hora</label>
            <input type="text" id="fecha_hora" name="fecha_hora" value="{{date('Y-m-d')}}"><br>

            <input type="file" name="imagen[]" id="imagen" {{--accept="image/png, image/jpg, image/jpeg"--}} multiple="multiple">
            @error('imagen')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            {{--<div id="dropzone" class="dropzone">
                Imagenes...
            </div>--}}
            <div id="queue" class="queue"></div>



            <button class="btn btn-primary" type="submit">Guardar</button>
        </form>

        <br><br>
        <button id="btnprueba" type="button" class="btn btn-sm btn-secondary">prueba</button>

        <p>If you click the "Submit" button, the form-data will be sent to a page called "/action_page.php".</p>

        <!-- product details description area start -->
        <div class="description-review-area mb-50px bg-light-gray-3 ptb-50px">
            <div class="container">
                <div class="description-review-wrapper">
                    <div class="description-review-topbar nav">
                        <a data-toggle="tab" href="#des-details1">Description</a>
                        <a class="active" data-toggle="tab" href="#des-details2">Product Details</a>
                        <a data-toggle="tab" href="#des-details3">Reviews (2)</a>
                    </div>
                    <div class="tab-content description-review-bottom">
                        <div id="des-details2" class="tab-pane active">
                            <div class="product-anotherinfo-wrapper">
                                <ul>
                                    <li><span>Weight</span> 400 g</li>
                                    <li><span>Dimensions</span>10 x 10 x 15 cm</li>
                                    <li><span>Materials</span> 60% cotton, 40% polyester</li>
                                    <li><span>Other Info</span> American heirloom jean shorts pug seitan letterpress</li>
                                </ul>
                                <table style="height: 58px;" width="731"> <tbody> <tr> <td style="width: 236.333px;">&nbsp;</td> <td style="width: 236.333px; text-align: center;"> <h2>titulo de esto</h2> </td> <td style="width: 236.333px;">&nbsp;</td> </tr> <tr> <td style="width: 236.333px;"> <ul> <li>ahahsksksks</li> <li>askskskd</li> <li>adfsdfsd</li> <li>asdfsfdsf</li> <li><strong>jsjsjs:</strong> asdfsfd</li> </ul> </td> <td style="width: 236.333px;"> <ol> <li>asdfsdfs</li> <li>asfsf</li> <li>asdfsww</li> <li>asdfss</li> <li><em><strong>asdfsdf: adf</strong></em><strong>asdss</strong>sssss</li> </ol> </td> <td style="width: 236.333px;"> <ul style="list-style-type: disc;"> <li>asdfsdfsss</li> <li>asdfsdfsf</li> </ul> <p>asdsssdfsdfsf sdsdfsdfssss</p> <p>sdfsdfdfs</p> </td> </tr> </tbody> </table> <p>&nbsp;</p>
                            </div>
                        </div>
                        <div id="des-details1" class="tab-pane">
                            <div class="product-description-wrapper">
                                <ul> <li>ahahsksksks</li> <li>askskskd</li> <li>adfsdfsd</li> <li>asdfsfdsf</li> <li><strong>jsjsjs:</strong> asdfsfd</li> </ul>
                                <table style="height: 58px;" width="731"> <tbody> <tr> <td style="width: 236.333px;">&nbsp;</td> <td style="width: 236.333px; text-align: center;"> <h2>titulo de esto</h2> </td> <td style="width: 236.333px;">&nbsp;</td> </tr> <tr> <td style="width: 236.333px;"> <ul> <li>ahahsksksks</li> <li>askskskd</li> <li>adfsdfsd</li> <li>asdfsfdsf</li> <li><strong>jsjsjs:</strong> asdfsfd</li> </ul> </td> <td style="width: 236.333px;"> <ol> <li>asdfsdfs</li> <li>asfsf</li> <li>asdfsww</li> <li>asdfss</li> <li><em><strong>asdfsdf: adf</strong></em><strong>asdss</strong>sssss</li> </ol> </td> <td style="width: 236.333px;"> <ul style="list-style-type: disc;"> <li>asdfsdfsss</li> <li>asdfsdfsf</li> </ul> <p>asdsssdfsdfsf sdsdfsdfssss</p> <p>sdfsdfdfs</p> </td> </tr> </tbody> </table> <p>&nbsp;</p>
                            </div>
                        </div>
                        <div id="des-details3" class="tab-pane">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="review-wrapper">
                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="assets/images/review-image/1.png" alt="" />
                                            </div>
                                            <div class="review-content">
                                                <div class="review-top-wrap">
                                                    <div class="review-left">
                                                        <div class="review-name">
                                                            <h4>White Lewis</h4>
                                                        </div>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                    </div>
                                                    <div class="review-left">
                                                        <a href="#">Reply</a>
                                                    </div>
                                                </div>
                                                <div class="review-bottom">
                                                    <p>
                                                        Vestibulum ante ipsum primis aucibus orci luctustrices posuere cubilia Curae Suspendisse viverra ed viverra. Mauris ullarper euismod vehicula. Phasellus quam nisi, congue id nulla.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="single-review child-review">
                                            <div class="review-img">
                                                <img src="assets/images/review-image/2.png" alt="" />
                                            </div>
                                            <div class="review-content">
                                                <div class="review-top-wrap">
                                                    <div class="review-left">
                                                        <div class="review-name">
                                                            <h4>White Lewis</h4>
                                                        </div>
                                                        <div class="rating-product">
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                            <i class="ion-android-star"></i>
                                                        </div>
                                                    </div>
                                                    <div class="review-left">
                                                        <a href="#">Reply</a>
                                                    </div>
                                                </div>
                                                <div class="review-bottom">
                                                    <p>Vestibulum ante ipsum primis aucibus orci luctustrices posuere cubilia Curae Sus pen disse viverra ed viverra. Mauris ullarper euismod vehicula.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="ratting-form-wrapper pl-50">
                                        <h3>Add a Review</h3>
                                        <div class="ratting-form">
                                            <form action="#">
                                                <div class="star-box">
                                                    <span>Your rating:</span>
                                                    <div class="rating-product">
                                                        <i class="ion-android-star"></i>
                                                        <i class="ion-android-star"></i>
                                                        <i class="ion-android-star"></i>
                                                        <i class="ion-android-star"></i>
                                                        <i class="ion-android-star"></i>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="rating-form-style mb-10">
                                                            <input placeholder="Name" type="text" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="rating-form-style mb-10">
                                                            <input placeholder="Email" type="email" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="rating-form-style form-submit">
                                                            <textarea name="Your Review" placeholder="Message"></textarea>
                                                            <input type="submit" value="Submit" />
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
        <!-- product details description area end -->


    </div>
@endsection

@section('footer_scripts')
    <script src="{{asset('js/tinymce.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function (){

            asignarDatepicker($("#fecha_dos"));

            //var easyMDE = new EasyMDE({element: $('#my-text-area')[0]});

            //$('').summernote();
            /*$('#my-text-area').summernote({
                placeholder: 'Hello Bootstrap 4',
                tabsize: 2,
                height: 100
            });*/

            tinymce.init({
                selector: '#descripcion',
                language: 'es',
                theme: 'modern',
                width: 800,
                height: 300,
                plugins: [
                    /*'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                    'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
                    'save table contextmenu directionality emoticons template paste textcolor','image'*/
                    //,'media'
                    'advlist lists charmap preview hr searchreplace wordcount visualblocks visualchars fullscreen',
                    'insertdatetime nonbreaking table contextmenu directionality paste'
                ],
            });

            $("#btnprueba").click(function (){
                $.confirm({
                    theme: 'modern',
                    title: false,
                    content: 'hoalala aaaa',
                    buttons: {
                        SI: {
                            text: 'SI',
                            btnClass: 'btn-blue',
                            keys: ['enter'],
                            action: function(){

                            }

                        },
                        NO: {
                            text: 'NO',
                            btnClass: 'btn-red',
                            action: function(){

                            }

                        }


                    }
                });
            });
        });

    </script>
@endsection
