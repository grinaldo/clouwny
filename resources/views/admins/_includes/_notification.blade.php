@if ($notif_success = Session::get(NOTIF_SUCCESS))
<div class="alert alert-success">
    <a class="close" data-close="alert"></a>
    <span> {{ $notif_success }}</span>
</div>
@endif
@if ($notif_info = Session::get(NOTIF_INFO))
<div class="alert alert-info">
    <a class="close" data-close="alert"></a>
    <span> {{ $notif_info }}</span>
</div>
@endif
@if ($notif_warning = Session::get(NOTIF_WARNING))
<div class="alert alert-warning">
    <a class="close" data-close="alert"></a>
    <span> {{ $notif_warning }}</span>
</div>
@endif
@if ($notif_danger = Session::get(NOTIF_DANGER))
<div class="alert alert-danger">
    <a class="close" data-close="alert"></a>
    <span> {{ $notif_danger}}</span>
</div>
@endif
