<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoticiaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ContactoController;

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

// Portada
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Ruta para el formulario de contacto
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto');
Route::post('/contacto', [ContactoController::class, 'send'])->name('contacto.email');

// CRUD de noticias
Route::get('/noticias/create', [NoticiaController::class, 'create'])->name('noticias.create'); // Nueva noticia
Route::post('/noticias', [NoticiaController::class, 'store'])->name('noticias.store'); // Guardar noticia
Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index'); // Listado
Route::get('/noticias/search', [NoticiaController::class, 'search'])->name('noticias.search'); // Búsqueda
Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show'); // Detalles
Route::get('/noticias/{noticia}/edit', [NoticiaController::class, 'edit'])->name('noticias.edit'); // Editar
Route::put('/noticias/{noticia}', [NoticiaController::class, 'update'])->name('noticias.update'); // Actualizar
Route::get('/noticias/{noticia}/delete', [NoticiaController::class, 'delete'])->name('noticias.delete'); // Conf. Borrado
Route::delete('/noticias/{noticia}', [NoticiaController::class, 'destroy'])->name('noticias.destroy'); // Eliminar

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

