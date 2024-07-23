<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Noticia;

class NoticiaComposer{

    // método que vincula la información a la vista
    public function compose(View $view){
        $view->with('total', Noticia::count());
    }
}