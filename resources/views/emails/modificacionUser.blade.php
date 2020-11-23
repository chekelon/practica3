<html>
    <head>
        <title>App Name - @yield('Acceso Restringido')</title>
    </head>
    <body>
        El usuario <b>{{$user->name}}</b> con correo <b>{{$user->email}}</b>
        <p></p>
        Se modifico sus permisos a {{$user->TipoUser}} .....

        
    </body>
</html>