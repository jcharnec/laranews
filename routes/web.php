<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoticiaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//portada
Route::get('/', function () {
    return view('welcome');
});

// CRUD de noticias
Route::get('/noticias/create', [NoticiaController::class, 'create'])->name('noticias.create');         //nueva noticia
Route::post('/noticias', [NoticiaController::class, 'store'])->name('noticias.store');                 //guardar moto

Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');                  //listado
Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show');           //detalles

Route::get('/noticias/{noticia}/edit', [NoticiaController::class, 'edit'])->name('noticias.edit');      //editar
Route::put('/noticias/{noticia}', [NoticiaController::class, 'update'])->name('noticias.update');       //actualizar

Route::get('/noticias/{noticia}/delete', [NoticiaController::class, 'delete'])->name('noticias.delete');  //conf.borrado
Route::delete('/noticias/{noticia}', [NoticiaController::class, 'destroy'])->name('noticias.destroy');  //eliminar


