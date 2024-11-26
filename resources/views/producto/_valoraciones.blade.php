@foreach($valoraciones as $key => $valo)
    <div class="single-review">
        <div class="review-content">
            <div class="review-top-wrap">
                <div class="review-left">
                    <div class="review-name">
                        <h4>{{$valo->usuario->name}}</h4>
                    </div>
                    <div class="rating-product">
                        @switch($valo->puntuacion)
                            @case(1)
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star sincolor-estrella"></i>
                            <i class="ion-android-star sincolor-estrella"></i>
                            <i class="ion-android-star sincolor-estrella"></i>
                            <i class="ion-android-star sincolor-estrella"></i>
                            @break
                            @case(2)
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star sincolor-estrella"></i>
                            <i class="ion-android-star sincolor-estrella"></i>
                            <i class="ion-android-star sincolor-estrella"></i>
                            @break
                            @case(3)
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star sincolor-estrella"></i>
                            <i class="ion-android-star sincolor-estrella"></i>
                            @break
                            @case(4)
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star sincolor-estrella"></i>
                            @break
                            @case(5)
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            @break
                            @default
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star sincolor-estrella"></i>
                            <i class="ion-android-star sincolor-estrella"></i>
                        @endswitch
                    </div>
                </div>
                <div class="review-left">
                </div>
            </div>
            <div class="review-bottom">
                <p>{{$valo->valoracion}}</p>
            </div>
        </div>
    </div>
@endforeach
