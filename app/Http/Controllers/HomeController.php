<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {
        $user = $request->user();
        $noticias = $user->noticias()->paginate(10);
        $comentarios = $user->comentarios()->with('noticia')->paginate(10);

        return view('home', [
            'user' => $user,
            'noticias' => $noticias,
            'comentarios' => $comentarios,
        ]);
    }
}
