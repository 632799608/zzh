<html>
    <head>
        <title>App Name - @yield('title')</title>
    </head>
    <body>
        @section('sidebar')
            @include('admin.public.meta')
            @include('admin.public.footer')
        @show
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
