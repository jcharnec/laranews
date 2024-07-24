<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoticiaApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});*/

Route::get( // recuperar todas las noticias
    '/noticias',
    [NoticiaApiController::class, 'index']
);

Route::get( // recuperar una noticia por ID
    '/noticia/{noticia}',
    [NoticiaApiController::class, 'show']
)->where('noticia', '^\d+$'); // solamente dígitos

Route::get( // buscar una noticia por titulo, tema
    '/noticias/{campo}/{valor}',
    [NoticiaApiController::class, 'search']
)->where('campo', '^titulo|tema|texto$');

Route::post( // añadir una noticia
    '/noticia',
    [NoticiaApiController::class, 'store']
);

Route::put( //modificar una noticia
    '/noticia/{noticia}',
    [NoticiaApiController::class, 'update']
);

Route::delete( // borrar una noticia
    '/noticia/{noticia}',
    [NoticiaApiController::class, 'delete']
);

//ruta de fallback: se ha producido una petición incorrecta
Route::fallback(function(){
    return response(['status' => 'BAD REQUEST'], 400);
});
