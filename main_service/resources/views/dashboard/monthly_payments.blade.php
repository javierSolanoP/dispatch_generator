<!DOCTYPE html>
<html lang="es-CO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Styles -->
    <link rel="stylesheet" href="../../css/dashboard.css">
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
    <script  type="module" src="../../js/monthly_payments.js"></script>
</body>
</html>