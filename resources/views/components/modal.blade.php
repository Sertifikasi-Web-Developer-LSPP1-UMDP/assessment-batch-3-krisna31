@props(['id_modal', 'is_form', 'modal_size' => 'lg'])

<div class="modal fade" id="{{ $id_modal }}" role="dialog">
    <div class="modal-dialog modal-{{ $modal_size }}" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="col modal-title">
                    <span id="modal-header-title">-</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h4>
            </div>
            @if ($is_form == 'true')
                @include('errors.validation')
                <form autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            {{ $slot }}
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success submit-button"></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            @else
                <div class="modal-body">
                    {{ $slot }}
                </div>
            @endif
        </div>
    </div>
</div>
