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

    <link rel="stylesheet" href="../../css/components/nav.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../css/main/main.css">
    <title>@include('components.title')</title>
</head>
<body>
    @include('components.nav')
    <section id="component">
        <div class="container">
            <div class="container-button">
                <button>
                    <img src="../../images/users.png" alt="usuarios">
                </button>
                <button>
                    <img src="../../images/permissions.png" alt="permisos">
                </button>
            </div>
            <div class="container-button">
                <button>
                    <img src="../../images/roles.png" alt="roles">
                </button>
                <button>
                    <img src="../../images/services.png" alt="servicios">
                </button>
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