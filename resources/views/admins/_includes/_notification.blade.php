@if ($notif_success = Session::get(NOTIF_SUCCESS))
<div class="alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <strong>Success!</strong> {{ $notif_success }}
    </div>
</div>
@endif
@if ($notif_info = Session::get(NOTIF_INFO))
<div class="alert alert-info alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <strong>Info:</strong> {{ $notif_info }}
    </div>
</div>
@endif
@if ($notif_warning = Session::get(NOTIF_WARNING))
<div class="alert alert-warning alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <strong>Warning!</strong> {{ $notif_warning }}
    </div>
</div>
@endif
@if ($notif_danger = Session::get(NOTIF_DANGER))
<div class="alert alert-danger alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <strong>Error!</strong> {{ $notif_danger }}
    </div>
</div>
@endif
