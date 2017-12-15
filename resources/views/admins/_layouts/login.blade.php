<!DOCTYPE html>
<html lang="en">
    <head>
        @include('admins._includes._head-meta')
        @include('admins._includes._head-style')
        @include('admins._includes._head-script')
    </head>
    <body class="login">
        @yield('content')
        @include('admins._includes._foot-script')
        @yield('page-script')
    </body>
</html>