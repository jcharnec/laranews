<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //carga la vista para los usuarios bloqueados
    /**
     * Summary of blocked
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function blocked()
    {
        return view('blocked');
    }
}
