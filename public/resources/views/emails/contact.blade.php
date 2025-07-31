<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mensaje recibido - {{ config('app.name') }}</title>
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
            background: #f8f9fa;
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

        .content h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #ff6600;
        }

        .content p {
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .message-box {
            background: #f8f9fa;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            padding: 15px;
            font-style: italic;
            margin-top: 10px;
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
            <h1>{{ config('app.name') }}</h1>
        </div>

        <!-- Contenido principal -->
        <div class="content">
            <h2>Mensaje recibido: <span>{{ $mensaje->asunto }}</span></h2>
            <p>De <strong>{{ $mensaje->nombre }}</strong> &lt;<a href="mailto:{{ $mensaje->email }}">{{ $mensaje->email }}</a>&gt;</p>

            <div class="message-box">
                {{ $mensaje->mensaje }}
            </div>
        </div>

        <!-- Pie -->
        <div class="footer">
            <p>Aplicación creada por {{ $autor }} para {{ $centro }} como ejemplo de clase.</p>
            <p>Desarrollada con <strong>Laravel</strong> y <strong>Bootstrap</strong>.</p>
        </div>
    </div>
</body>

</html>
