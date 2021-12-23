<!DOCTYPE html>
<html lang="es-CO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Architects+Daughter&family=Catamaran&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../css/ViewAdd.css">
    <link rel="stylesheet" href="../../css/AddUser.css">
    <title>@include('components.title')</title>
</head>
<body>
    @include('components.nav')
    <section id="component">
        <div class="container">
            <div class="container-button">
                <button class="add" id="addButton">
                    <img src="../../images/agregar-usuario.png" alt="Icono de agregar usuarios">
                </button>
                <div class="description">
                    <strong>AÑADIR</strong>
                    <ul>
                        <li>Añada nuevos usuarios.</li>
                        <li>Añada permisos a usuarios.</li>
                        <li>Añada servicios a usuarios.</li>
                    </ul>
                </div>
            </div>
            <div class="container-button reverse">
                <button class="update">
                    <img src="../../images/actualizar-usuario.png" alt="Icono de agregar usuarios">
                </button>
                <div class="description reverse">
                    <strong>EDITAR</strong>
                    <ul>
                        <li>Edite usuarios.</li>
                        <li>Edite permisos de usuarios.</li>
                        <li>Edite servicios de usuarios.</li>
                    </ul>
                </div>
            </div>
            <div class="container-button">
                <button class="delete">
                    <img src="../../images/eliminar-usuario.png" alt="Icono de agregar usuarios">
                </button>
                <div class="description">
                    <strong>ELIMINAR</strong>
                    <ul>
                        <li>Elimine usuarios.</li>
                        <li>Elimine permisos de usuarios.</li>
                        <li>Elimine servicios de usuarios.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div id="add" class="view">
        @include('dashboard.ViewAdd')
    </div>

    <!-- Scripts -->
    <script type="module" src="../../js/components/ObjComponent.js"></script>
    <script type="module" src="../../js/main.js"></script>
</body>
</html>