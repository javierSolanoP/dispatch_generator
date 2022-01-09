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
    <form action="{{ route('process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="dispatch" ><br>
        <div class="container">
            <input type="submit" value="Procesar">
            <form action="{{ route('generate') }}" method="POST">
                @csrf
                <input type="submit" value="Generar">
            </form>
        </div>
    </form>
</body>
</html>