<!DOCTYPE html>
<html lang="es-CO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Styles -->
    <link rel="stylesheet" href="css/dashboard.css">
    <title>@include('components/title')</title>
</head>
<body>
    <nav>
        <div class="container-avatar">
            <img src="images/{{$data['avatar']}}" alt="Avatar">
            <br>
            <p>{{ $data['name'] }} {{ $data['last_name'] }}</p>
        </div>
        <ul>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <button class="logout">
            <img src="images/salida.png" alt="Icono de cerrar sesion">
            <p>Cerrar sesión</p>
        </button>
    </nav>
</body>
</html>