<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de Usuario </title>
</head>
<body>
    <h1>Sistema de Gestión de Cupos para Practicas Pre-Profesionales</h1>
    <h2>Registro de Usuario Nuevo</h2>
    <h3>Se ha registro el Usuario</h3>
    <p><b>Nombre: </b> {{$msg['nombre_completo']}}</p>
    <p><b>Correo Electronico: </b>{{$msg['email']}}</p>
    <h3>Por favor, Verificar los datos para su activación</h3>
    Gracias,<br>
    {{ config('app.name') }}
</body>
</html>