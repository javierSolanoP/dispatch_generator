<!DOCTYPE html>
<html lang="es-CO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap" rel="stylesheet">
        
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/monthly_payment.css">
    <title>@include('components.title')</title>
</head>
<body>
    @include('components.nav')
    <section>
        <div class="container-menu">
            <div class="menu">
                <button id="view">
                    <img src="../../images/mensualidad.png" alt="Icono de mensualidades">
                </button>
            </div>
        </div>
    </section>
    <section class="content"></section>
    
    <!-- Scripts -->
    <script  type="module" src="../../js/ObjComponent.js"></script>
    <script  type="module" src="../../js/monthly_payment.js"></script>
</body>
</html>