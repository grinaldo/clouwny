@if ($notif_success = Session::get(NOTIF_SUCCESS))
<div class="alert-box">
    <div class="alert alert-success">
        {{ $notif_success }}
        <span class="close" onclick="$(this).parent().fadeOut();">&times;</span> 
    </div>
</div>
@endif
@if ($notif_info = Session::get(NOTIF_INFO))
<div class="alert-box">
    <div class="alert alert-info">
        {{ $notif_info }}
        <span class="close" onclick="$(this).parent().fadeOut();">&times;</span> 
    </div>
</div>
@endif
@if ($notif_warning = Session::get(NOTIF_WARNING))
<div class="alert-box">
    <div class="alert alert-warning">
        {{ $notif_warning }}
        <span class="close" onclick="$(this).parent().fadeOut();">&times;</span> 
    </div>
</div>
@endif
@if ($notif_danger = Session::get(NOTIF_DANGER))
<div class="alert-box">
    <div class="alert alert-danger">
        {{ $notif_danger }}
        <span class="close" onclick="$(this).parent().fadeOut();">&times;</span> 
    </div>
</div>
@endif
