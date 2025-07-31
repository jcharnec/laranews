<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticia publicada</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 640px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .header {
            background-color: #f8f9fa;
            padding: 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e5e5e5;
        }

        .header img {
            max-width: 80px;
            margin-right: 15px;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
            color: #000;
        }

        .content {
            padding: 25px;
        }

        .content h1 {
            color: #28a745;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .content h2 {
            font-size: 16px;
            margin-bottom: 20px;
            color: #555;
        }

        .content p {
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .footer {
            background: #f8f9fa;
            color: #666;
            font-size: 13px;
            text-align: center;
            padding: 15px;
            border-top: 1px solid #e5e5e5;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Cabecera -->
        <div class="header">
            <img src="{{ asset('images/logos/logo.png') }}" alt="Logo">
            <h1>{{ config('app.name', 'LaraNews') }}</h1>
        </div>

        <!-- Cuerpo -->
        <div class="content">
            <h1>¡Felicidades!</h1>
            <h2>Has publicado tu primera noticia en <strong>LaraNews</strong></h2>

            <p>Tu nueva noticia: <strong>{{ $noticia->titulo }}</strong> (tema: <em>{{ $noticia->tema }}</em>) ya aparece en los resultados del portal.</p>

            <p>Sigue así. Estás colaborando a que <strong>LaraNews</strong> se convierta en la primera red de usuarios de noticias de los <strong>CIFO</strong>.</p>
        </div>

        <!-- Pie -->
        <div class="footer">
            <p>Aplicación creada por {{ $autor }} como ejemplo de clase.</p>
            <p>Desarrollada con <strong>Laravel</strong> y <strong>Bootstrap</strong>.</p>
        </div>
    </div>
</body>

</html>
