<!DOCTYPE html>
<html lang="es-CO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Styles -->
    <link rel="stylesheet" href="css/welcome.css">
    <title>@include('components/title')</title>
</head>
<body>
    <section>
        <article>
            <div class="container-left">
                <h1>MODULO ADMINISTRADOR</h1>
            </div>
            <div class="container-right">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="container-input">
                        <label for="userName">Usuario</label>
                        <input type="text" name="userName" required placeholder=" nombre de usuario...">
                    </div>
                    <div class="container-input">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" required placeholder=" contraseña...">
                    </div>
                    <input type="submit" value="Ingresar">
                </form>
                <br>
                @if(isset($error))
                    <div class="error">
                        <h2>{{ $error }}</h2>
                    </div>
                @endif
            </div>
        </article>
    </section>
</body>
</html>