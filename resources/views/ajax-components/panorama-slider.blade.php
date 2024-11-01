<h5 class="card-title">Panorama</h5>
<div id="panorama-uploaded" class="splide" role="group" aria-label="Splide Basic HTML Example">
    <div class="splide__track">
        <ul class="splide__list" id="panorama-slider">
            @if (count($panorama) > 0)
                @foreach ($panorama as $img)
                    <li class="splide__slide" data-toggle="modal" data-target="#panorama{{ $img['id'] }}"><img
                            src="{{ $img['url'] }}" alt=""></li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
