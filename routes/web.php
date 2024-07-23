<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoticiaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\AdminController;

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

//grupo de rutas solamente para el administrador
//llevarán el prefijo 'admin'
Route::prefix('admin')->middleware('auth', 'is_admin')->group(function () {
    //ver las motos eliminadas (/admin/deletedbikes)
    Route::get('deletedNoticias', [AdminController::class, 'deletednoticias'])
            ->name('admin.deleted.noticias');
    //detalles de un usuario
    Route::get('usuario/{user}/detalles', [AdminController::class, 'userShow'])
            ->name('admin.user.show');
    //listado de usuarios
    Route::get('usuarios', [AdminController::class, 'userList'])
            ->name('admin.users');
    //búsqueda de usuarios
    Route::get('usuario/buscar', [AdminController::class, 'userSearch'])
            ->name('admin.users.search');
    // añadir un rol
    Route::post('role', [AdminController::class, 'setRole'])
            ->name('admin.user.setRole');
    //quitar un rol
    Route::delete('role', [AdminController::class, 'removeRole'])
            ->name('admin.user.removeRole');
});

Auth::routes(['verify' => true]);

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Portada
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Ruta para el formulario de contacto
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto');
Route::post('/contacto', [ContactoController::class, 'send'])->name('contacto.email');

// CRUD de noticias
Route::get('/noticias/create', [NoticiaController::class, 'create'])->name('noticias.create'); // Nueva noticia
Route::post('/noticias', [NoticiaController::class, 'store'])->name('noticias.store'); // Guardar noticia
Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index'); // Listado
Route::get('/noticias/search/{titulo?}/{tema?}', [NoticiaController::class, 'search'])->name('noticias.search'); // Búsqueda
Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show'); // Detalles
Route::get('/noticias/{noticia}/edit', [NoticiaController::class, 'edit'])->name('noticias.edit'); // Editar
Route::put('/noticias/{noticia}', [NoticiaController::class, 'update'])->name('noticias.update'); // Actualizar
Route::get('/noticias/{noticia}/delete', [NoticiaController::class, 'delete'])->name('noticias.delete'); // Conf. Borrado
Route::delete('/noticias/{noticia}', [NoticiaController::class, 'destroy'])->name('noticias.destroy'); // Eliminar

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//RUTA DE FALLBACK, ruta a la que irá si no coinciden las demás rutas.
Route::fallback([WelcomeController::class, 'index']);