<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;

class WelcomeController extends Controller
{
    public function index()
    {
        // Recuperar las últimas 4 noticias
        $noticias = Noticia::latest()->take(3)->get();
        $total = Noticia::count();

        // Pasar las noticias y el total a la vista
        return view('welcome', compact('noticias', 'total'));
    }
}
