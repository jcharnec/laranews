<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @php 
            include 'css/bootstrap.min.css';
        @endphp
    </style>
</head>

<body class="container p-3">
    <header class="container row bg-light p-4 my-4">
        <figure class="img-fluid col-2">
            <img src="{{asset('images/logos/logo.png')}}" alt="logo">
        </figure>
    </header>
    <main>
        <h1>Felicidades</h1>
        <h2>Has publicado tu primera noticia en LaraNews!</h2>
        <p>Tu nueva noticia {{$noticia->titulo.' '.$noticia->tema}} ya
            aparece en los resultados.
        </p>
        <p>Sigue así, estás colaborando para que LaraNews
            se convierta en la primera red
            de usuarios de noticias de los CIFO.</p>
        </p>
    </main>
    <footer class="page-footer font-small p-4 my-4 bg-light">
        <p>Aplicación creada por {{ $autor }} como ejemplo de clase.</p>
        <b>Desarrollada haciendo uso de <b>Laravel</b> y <b>Bootstrap</b>.</p>
    </footer>
</body>
</html>