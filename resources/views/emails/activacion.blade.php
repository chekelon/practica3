<html>
    <head>
        <title>App Name - @yield('title')</title>
    </head>
    <body>
        Bienvenido 

        Favor de activar su cuenta....
        Hola {{$user->name}}
        Te has registrado con el correo {{$user->email}}
        <a href="http://127.0.0.1:8000/api/activacion/{{$user->id}}">Activar cuenta...</a>
    </body>
</html>