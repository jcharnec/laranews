<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;

class WelcomeController extends Controller
{
    public function index()
    {
        // Traer todas las noticias
        $noticias = Noticia::latest()->get();

        // Carrusel con las 3 primeras
        $destacadas = $noticias->take(3);

        // 3 noticias más (de la 4 a la 6)
        $resto = $noticias->skip(3)->take(3);

        // Total de noticias
        $total = $noticias->count();

        return view('welcome', compact('destacadas', 'resto', 'total'));
    }
}
