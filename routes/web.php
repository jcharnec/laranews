<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Controladores de tu app
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UserController;


// Controlador de registro (forzamos el de Auth)
use App\Http\Controllers\Auth\RegisterController as AuthRegister;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Aquí se registran todas las rutas de la aplicación.
|
| Nota: desactivamos las rutas /register del scaffold y las declaramos abajo
| apuntando explícitamente a Auth\RegisterController para garantizar que se
| ejecute tu método register() que guarda el avatar.
*/

// ===============================
// Zona admin (prefijo /admin)
// ===============================
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {

    // Noticias eliminadas (papelera)
    Route::get('deletedNoticias', [AdminController::class, 'deletedNoticias'])
        ->name('admin.deleted.noticias');

    // Restaurar noticia eliminada
    Route::put('noticias/{id}/restore', [AdminController::class, 'restoreNoticia'])
        ->name('admin.noticias.restore');

    // Eliminar noticia definitivamente
    Route::delete('noticias/{id}/forceDelete', [AdminController::class, 'forceDeleteNoticia'])
        ->name('admin.noticias.forceDelete');

    // Detalles de un usuario
    Route::get('usuario/{user}/detalles', [AdminController::class, 'userShow'])
        ->name('admin.user.show');

    // Listado de usuarios
    Route::get('usuarios', [AdminController::class, 'userList'])
        ->name('admin.users');

    // Búsqueda de usuarios
    Route::get('usuario/buscar', [AdminController::class, 'userSearch'])
        ->name('admin.users.search');

    // Añadir un rol a un usuario
    Route::post('role', [AdminController::class, 'setRole'])
        ->name('admin.user.setRole');

    // Quitar un rol a un usuario
    Route::delete('role', [AdminController::class, 'removeRole'])
        ->name('admin.user.removeRole');

    // Eliminar un usuario
    Route::delete('/admin/users/{user}', [AdminController::class, 'userDestroy'])->name('admin.user.destroy');

    // Papelera de usuarios
    Route::get('/admin/users/deleted', [AdminController::class, 'deletedUsers'])->name('admin.deleted.users');
    Route::post('/admin/users/{id}/restore', [AdminController::class, 'restoreUser'])->name('admin.user.restore');
    Route::delete('/admin/users/{id}/force-delete', [AdminController::class, 'forceDeleteUser'])->name('admin.user.forceDelete');
});

// ===============================
// Auth + verificación email
// ===============================

// Desactivamos las rutas de /register del scaffold
Auth::routes([
    'verify'   => true,
    'register' => false,
]);

// Declaramos explícitamente las rutas de registro usando Auth\RegisterController
Route::get('register',  [AuthRegister::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthRegister::class, 'register']);

// Reenviar verificación de email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ===============================
// Portada
// ===============================
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// ===============================
// Contacto
// ===============================
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto');
Route::post('/contacto', [ContactoController::class, 'send'])->name('contacto.email');

// ===============================
// CRUD de noticias
// ===============================
Route::get('/noticias/create', [NoticiaController::class, 'create'])->name('noticias.create'); // Nueva noticia
Route::post('/noticias', [NoticiaController::class, 'store'])->name('noticias.store');         // Guardar noticia
Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');          // Listado
Route::get('/noticias/search/{titulo?}/{tema?}', [NoticiaController::class, 'search'])->name('noticias.search'); // Búsqueda
Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show');  // Detalles
Route::get('/noticias/{noticia}/edit', [NoticiaController::class, 'edit'])->name('noticias.edit');               // Editar
Route::put('/noticias/{noticia}', [NoticiaController::class, 'update'])->name('noticias.update');                // Actualizar
Route::get('/noticias/{noticia}/delete', [NoticiaController::class, 'delete'])->name('noticias.delete');         // Confirmar borrado
Route::delete('/noticias/{noticia}', [NoticiaController::class, 'destroy'])->name('noticias.destroy');           // Borrar

// Guardar comentario en una noticia (solo usuarios autenticados)
Route::post('/noticias/{noticia}/comentarios', [NoticiaController::class, 'storeComentario'])
    ->middleware('auth')
    ->name('noticias.comentarios.store');

Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])
    ->middleware('auth')
    ->name('comentarios.destroy');

// ===============================
// Home (panel de usuario)
// ===============================
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/perfil/editar', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil/editar', [PerfilController::class, 'update'])->name('perfil.update');
});
Route::delete('/perfil', [UserController::class, 'destroy'])->name('user.destroy')->middleware(['auth', 'verified']);


// ===============================
// Fallback
// ===============================
Route::fallback([WelcomeController::class, 'index']);
