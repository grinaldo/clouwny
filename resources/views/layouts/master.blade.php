<!DOCTYPE html>
<html lang="en">
    <head>
        @include('_includes._head-meta')
        @include('_includes._head-style')
        @include('_includes._head-script')
    </head>
    <body>
        <div class="overlay"></div>
        @include('_includes._header')
        @include('_includes._sidebar')
        
        <div id="app"></div> 
        @include('_includes._notification')
        @yield('content')  

        @include('_includes._footer')
        @include('_includes._foot-script')
        @yield('page-script')
    </body>
</html>