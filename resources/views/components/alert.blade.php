@props(['type', 'message'])

@if ($message)
    <div class="col-12">
        <div class="alert alert-important alert-{{ $type }} alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <i class="ti ti-info-circle me-2"></i>
                </div>
                <div>
                    {{ $message }}
                </div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    </div>
@endif
