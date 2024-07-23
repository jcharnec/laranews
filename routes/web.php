<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoticiaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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

// Grupo de rutas solamente para el administrador
// Llevarán el prefijo 'admin'
Route::prefix('admin')->middleware('auth', 'is_admin')->group(function () {
        Route::get('deletedNoticias', [AdminController::class, 'deletednoticias'])
                ->name('admin.deleted.noticias');
        Route::get('usuario/{user}/detalles', [AdminController::class, 'userShow'])
                ->name('admin.user.show');
        Route::get('usuarios', [AdminController::class, 'userList'])
                ->name('admin.users');
        Route::get('usuario/buscar', [AdminController::class, 'userSearch'])
                ->name('admin.users.search');
        Route::post('role', [AdminController::class, 'setRole'])
                ->name('admin.user.setRole');
        Route::delete('role', [AdminController::class, 'removeRole'])
                ->name('admin.user.removeRole');
});

Auth::routes(['verify' => true]);

//ruta de usuarios bloqueados
Route::get('/bloqueado', [UserController::class, 'blocked'])
        ->name('user.blocked');

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
Route::get('/noticias/create', [NoticiaController::class, 'create'])->name('noticias.create');
Route::post('/noticias', [NoticiaController::class, 'store'])->name('noticias.store');
Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
Route::get('/noticias/search/{titulo?}/{tema?}', [NoticiaController::class, 'search'])->name('noticias.search');
Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show');
Route::get('/noticias/{noticia}/edit', [NoticiaController::class, 'edit'])->name('noticias.edit');
Route::put('/noticias/{noticia}', [NoticiaController::class, 'update'])->name('noticias.update');
Route::get('/noticias/{noticia}/delete', [NoticiaController::class, 'delete'])->name('noticias.delete');
Route::delete('/noticias/{noticia}', [NoticiaController::class, 'destroy'])->name('noticias.destroy');

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Ruta de fallback
Route::fallback([WelcomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
