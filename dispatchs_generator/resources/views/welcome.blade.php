<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/index.css">
    <title>Document</title>
</head>
<body>
    <header>
        <strong>Bienvenido, crack!</strong>
    </header>
    <form class="send" action="{{ route('process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="dispatch" ><br>
        <input type="submit" value="Procesar">
    </form><br>
    <form class="receive" action="{{ route('generate') }}" method="POST">
        @csrf
        <input type="submit" value="Generar">
    </form>
    @if (isset($_GET['confirm']))
        <script>
            alert("Se procesó correctamente, para generar el reporte de clic en el botón 'Generar'!")
        </script>
    @endif
</body>
</html>