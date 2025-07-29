<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Proyecto Laranews">
    <title>{{ config('app.name') }} - @yield('titulo')</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom styles -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- NAVBAR -->
    @section('navegacion')
    @php($pagina = Route::currentRouteName())
    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-white" href="{{ url('/') }}">
                {{ config('app.name', 'Laranews') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ $pagina == 'welcome' ? 'active' : '' }}" href="{{ route('welcome') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link {{ in_array($pagina, ['noticias.index', 'noticias.search']) ? 'active' : '' }}" href="{{ route('noticias.index') }}">Noticias</a></li>
                    <li class="nav-item"><a class="nav-link {{ $pagina == 'contacto' ? 'active' : '' }}" href="{{ route('contacto') }}">Contacto</a></li>
                    @auth
                    <li class="nav-item"><a class="nav-link {{ $pagina == 'home' ? 'active' : '' }}" href="{{ route('home') }}">Mis noticias</a></li>
                    <li class="nav-item"><a class="nav-link {{ $pagina == 'noticias.create' ? 'active' : '' }}" href="{{ route('noticias.create') }}">Nueva noticia</a></li>
                    @if(Auth::user()->hasRole('administrador'))
                    <li class="nav-item"><a class="nav-link {{ $pagina == 'admin.deleted.noticias' ? 'active' : '' }}" href="{{ route('admin.deleted.noticias') }}">Noticias borradas</a></li>
                    <li class="nav-item"><a class="nav-link {{ in_array($pagina, ['admin.users', 'admin.users.search']) ? 'active' : '' }}" href="{{ route('admin.users') }}">Gestión de usuarios</a></li>
                    @endif
                    @endauth
                </ul>

                <!-- Right -->
                <ul class="navbar-nav ms-auto">
                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    @endif
                    @if (Route::has('register'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }} ({{ Auth::user()->email }})
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a></li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @show

    <!-- CONTENIDO -->
    <div class="container-lg py-4 flex-grow-1">
        <main>
            <h1 class="mb-4 text-dark">Noticias de LaraNews</h1>
            <h2 class="mb-3">@yield('titulo')</h2>

            @if(Session::has('success'))
            <div class="alert alert-success shadow-sm">{{ Session::get('success') }}</div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger shadow-sm">
                <strong>Se han producido errores:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <p>Contamos con un total de <strong>{{ $total ?? 0 }}</strong> noticias en nuestro portal.</p>

            @yield('contenido')

            <!-- ENLACES -->
            <div class="text-center mt-4">
                @section('enlaces')
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">Atrás</a>
                <a href="{{ route('welcome') }}" class="btn btn-orange">Inicio</a>
                @show
            </div>
        </main>
    </div>

    <!-- FOOTER -->
    @section('pie')
    <footer class="custom-footer mt-auto">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="mb-2 mb-md-0">
                Aplicación creada por <strong>{{ $autor }}</strong> como ejemplo de Laravel.<br>
                Desarrollado con <i class="bi bi-laravel"></i> Laravel y <i class="bi bi-bootstrap"></i> Bootstrap.
            </div>
            <div>
                <a href="https://github.com/jcharnec" target="_blank" class="text-white me-3">
                    <i class="bi bi-github" style="font-size: 1.5rem;"></i>
                </a>
                <a href="https://www.linkedin.com/in/hotadev/" target="_blank" class="text-white">
                    <i class="bi bi-linkedin" style="font-size: 1.5rem;"></i>
                </a>
            </div>
        </div>
    </footer>

    @show
</body>

</html>