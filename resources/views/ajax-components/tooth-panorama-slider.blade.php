@if (count($panorama) > 0)
    @foreach ($panorama as $img)
        <li class="splide__slide" data-toggle="modal" data-target="#panorama{{ $img['id'] }}"><img
                src="{{ $img['url'] }}" alt=""></li>
    @endforeach
@endif
