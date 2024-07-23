<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Proyecto Laranews">
    <title>{{ config('app.name') }} - @yield('titulo')</title>

    <!-- CSS para Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
</head>

<body class="container p-3">
    <!-- PARTE SUPERIOR -->
    @section('navegacion')
    @php($pagina = Route::currentRouteName())
    <div id="app">
        <div class="container">
            <h2 class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laranews') }}
            </h2>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <div class="container">
                        <ul class="nav nav-pills my-3">
                            <li class="nav-item mr-2">
                                <a class="nav-link {{ $pagina == 'portada' ? 'active' : '' }}" href="{{ route('welcome') }}">Inicio</a>
                            </li>
                            <li class="nav-item mr-2">
                                <a class="nav-link {{ $pagina == 'noticias.index' || $pagina == 'noticias.search' ? 'active' : '' }}" href="{{ route('noticias.index') }}">Noticias</a>
                            </li>
                            <li class="nav-item mr-2">
                                <a class="nav-link {{ $pagina == 'contacto' ? 'active' : '' }}" href="{{ route('contacto') }}">Contacto</a>
                            </li>
                            @guest
                            <li class="nav-item mr-2">
                                <a class="nav-link {{ $pagina == 'register' ? 'active' : '' }}" href="{{ route('register') }}">Registro</a>
                            </li>
                            @endguest

                            @auth
                            <li class="nav-item mr-2">
                                <a class="nav-link {{ $pagina == 'home' ? 'active' : '' }}" href="{{ route('home') }}">Mis noticias</a>
                            </li>
                            <li class="nav-item mr-2">
                                <a class="nav-link {{ $pagina == 'noticias.create' ? 'active' : '' }}" href="{{ action([App\Http\Controllers\NoticiaController::class, 'create']) }}">Nueva noticia</a>
                            </li>
                            @if(Auth::user()->hasRole('administrador'))
                            <li class="nav-item mr-2">
                                <a class="nav-link {{ $pagina == 'admin.deleted.noticias' ? 'active' : '' }}" href="{{ route('admin.deleted.noticias') }}">Noticias borradas</a>
                            </li>

                            <li class="nav-item mr-2">
                                <a class="nav-link {{ $pagina == 'admin.users' || $pagina == 'admin.users.search' ? 'active' : '' }}" href="{{ route('admin.users') }}">Gestión de usuarios</a>
                            </li>
                            @endif
                            @endauth
                        </ul>
                    </div>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @endif

                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} ({{ Auth::user()->email}})
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
    </div>
    </nav>
    </div>
    @show

    <!-- PARTE CENTRAL -->
    <h1 class="my-2">Noticias de LaraNews</h1>

    <main>
        <h2>@yield('titulo')</h2>

        @if(Session::has('success'))
        <x-alert type="success" message="{{ Session::get('success') }}" />
        @endif

        @if($errors->any())
        <x-alert type="danger" message="Se han producido errores:">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
        @endif

        <p>Contamos con un total de {{ $total ?? 0 }} noticias en nuestro portal.</p>

        @yield('contenido')
        <div class="d-flex justify-content-center">
            <div class="btn-group" role="group" aria-label="links">
                @section('enlaces')
                <a href="{{ url()->previous() }}" class="btn btn-primary m-2">Atrás</a>
                <a href="{{ route('welcome') }}" class="btn btn-primary m-2">Inicio</a>
                @show
            </div>
        </div>
        <!-- PARTE INFERIOR -->
        @section('pie')
        <footer class="page-footer font-small p-4 bg-light">
            <p>Aplicación creada por {{$autor}} como ejemplo de Laravel.
                Desarrollado haciendo uso de <b>Laravel</b> y <b>Bootstrap</b>.</p>
        </footer>
        @show
    </main>
</body>

</html>
