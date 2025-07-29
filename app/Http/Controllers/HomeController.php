<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    // app/Http/Controllers/HomeController.php
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $noticias = $user->noticias()
            ->orderByDesc('id')
            ->paginate(5);

        return view('home', compact('noticias'));
    }
}
