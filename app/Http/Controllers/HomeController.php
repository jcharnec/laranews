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
        $noticias = $request->user()->noticias()->paginate(config('pagination.noticias', 10));
        //$deletedBikes = $request->user()->bikes()->onlyTrashed()->get();

        return view('home', [
            'users' => $user,
            'noticias' => $noticias,
            //'deleteBikes' => $deletedBikes,
        ]);
    }
}
