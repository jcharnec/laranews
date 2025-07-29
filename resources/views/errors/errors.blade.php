<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $code ?? 'Error' }} - {{ $title ?? 'Error' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            max-width: 500px;
            padding: 2rem;
        }
    </style>
</head>

<body>
    <div class="container text-center error-container">
        <h1 class="display-1 text-danger fw-bold">{{ $code ?? 'Error' }}</h1>
        <p class="lead mb-3">{{ $title ?? 'Ha ocurrido un error' }}</p>
        <p class="text-muted">{{ $message ?? 'Algo no ha salido como esperábamos. Intenta de nuevo más tarde.' }}</p>
        <a href="{{ url('/') }}" class="btn btn-outline-primary mt-3">Volver al inicio</a>
    </div>
</body>

</html>