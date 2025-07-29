<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticia publicada</title>

    <!-- Bootstrap desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .banner {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
        }
    </style>
</head>

<body class="container py-4">
    <!-- Cabecera -->
    <header class="row align-items-center bg-light p-4 mb-4 rounded shadow-sm">
        <div class="col-auto">
            <img src="{{ asset('images/logos/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 100px;">
        </div>
        <div class="col">
            <h1 class="h4 mb-0">{{ config('app.name', 'LaraNews') }}</h1>
        </div>
    </header>

    <!-- Cuerpo -->
    <main class="banner shadow-sm mb-5">
        <h1 class="text-success">¡Felicidades!</h1>
        <h2 class="h5 mb-3">Has publicado tu primera noticia en <strong>LaraNews</strong></h2>

        <p>Tu nueva noticia: <strong>{{ $noticia->titulo }}</strong> (tema: <em>{{ $noticia->tema }}</em>) ya aparece en los resultados del portal.</p>

        <p>Sigue así. Estás colaborando a que <strong>LaraNews</strong> se convierta en la primera red de usuarios de noticias de los <strong>CIFO</strong>.</p>
    </main>

    <!-- Pie -->
    <footer class="bg-light p-4 rounded shadow-sm text-muted">
        <p class="mb-1">Aplicación creada por {{ $autor }} como ejemplo de clase.</p>
        <p class="mb-0">Desarrollada con <strong>Laravel</strong> y <strong>Bootstrap</strong>.</p>
    </footer>
</body>

</html>