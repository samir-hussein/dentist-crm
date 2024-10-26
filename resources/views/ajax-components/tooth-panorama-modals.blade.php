@if (count($panorama) > 0)
    @foreach ($panorama as $img)
        <div class="modal fade" id="panorama{{ $img['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <button aria-label="" type="button" class="close px-2" data-dismiss="modal" aria-hidden="true">
                <span aria-hidden="true">×</span>
            </button>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img src="{{ $img['url'] }}" alt="">
                    </div>
                </div>
            </div>
        </div> <!-- small modal -->
    @endforeach
@endif
