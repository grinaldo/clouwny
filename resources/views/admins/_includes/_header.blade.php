<div class="navbar nav_title" style="border: 0;">
    <a href="{{ url('/backend') }}" class="site_title"><i class="fa fa-paw"></i> <span>Backend Admin</span></a>
</div>
<div class="clearfix"></div>
<!-- menu profile quick info -->
<div class="profile clearfix">
    <div class="profile_pic">
        <img src="{{ asset('assets/admin/img/user-icon.png') }}" alt="..." class="img-circle profile_img">
    </div>
    @if(Auth::check())
    <div class="profile_info">
        <span>Welcome,</span>
        <h2>{{ Auth::user()->username }}</h2>
    </div>
    @endif
</div>
<!-- /menu profile quick info -->
<br />