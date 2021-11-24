<!DOCTYPE html>
<html lang="es-CO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Styles -->
    <link rel="stylesheet" href="css/welcome.css">
    <title>API Parking</title>
</head>
<body>
    <section>
        <article>
            <div class="container-left">
                {{-- <img src="images/welcome.svg" alt="Ilustracion de bienvenida"> --}}
                <h1>MODULO ADMINISTRADOR</h1>
            </div>
            <div class="container-right">
                
                <form action="{{ route('dashboard') }}" method="POST">
                    @csrf
                    <div class="container-input">
                        <label for="user">Usuario</label>
                        <input type="text" name="user" required placeholder=" nombre de usuario...">
                    </div>
                    <div class="container-input">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" required placeholder=" contraseña...">
                    </div>
                    <input type="submit" value="Ingresar">
                </form>
            </div>
        </article>
    </section>
</body>
</html>