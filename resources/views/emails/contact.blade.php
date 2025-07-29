<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mensaje recibido - {{ config('app.name') }}</title>

    <!-- Bootstrap desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        figure img {
            max-width: 100px;
            height: auto;
        }

        .cursiva {
            font-style: italic;
        }
    </style>
</head>

<body class="container py-4">
    <!-- Cabecera -->
    <header class="row align-items-center bg-light p-4 rounded shadow-sm mb-4">
        <div class="col-auto">
            <figure class="mb-0">
                <img src="{{ asset('images/logos/logo.png') }}" alt="Logo">
            </figure>
        </div>
        <div class="col">
            <h1 class="h3 mb-0">{{ config('app.name') }}</h1>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="mb-5">
        <h2 class="mb-3">Mensaje recibido: <span class="text-primary">{{ $mensaje->asunto }}</span></h2>
        <p class="cursiva">De {{ $mensaje->nombre }} &lt;<a href="mailto:{{ $mensaje->email }}">{{ $mensaje->email }}</a>&gt;</p>
        <div class="border rounded p-3 bg-white">
            <p class="mb-0">{{ $mensaje->mensaje }}</p>
        </div>
    </main>

    <!-- Pie de página -->
    <footer class="bg-light text-muted p-4 rounded shadow-sm">
        <p class="mb-0">Aplicación creada por {{ $autor }} para {{ $centro }} como ejemplo de clase.
            Desarrollada con <strong>Laravel</strong> y <strong>Bootstrap</strong>.</p>
    </footer>
</body>

</html>