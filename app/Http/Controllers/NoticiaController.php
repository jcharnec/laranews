<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\NoticiaRequest;
use App\Http\Requests\NoticiaUpdateRequest;

class NoticiaController extends Controller
{
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        //ponemos el middleware auth a todos los métodos excepto:
        // - lista de noticias
        // --detalles de noticias
        // - búsqueda de noticias
        $this->middleware(['verified'])->except('index', 'show', 'search');

        // el método para eliminar una noticia requiere confirmación de clave
        $this->middleware('password.confirm')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $noticias = Noticia::orderByDesc('id', 'DESC')->paginate(9);

        return View::make('noticias.list', [
            'noticias' => $noticias
        ]);
    }

    /**
     * Summary of search
     * @param \Illuminate\Http\Request $request
     * @param mixed $titulo
     * @param mixed $tema
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function search(Request $request, $titulo = null, $tema = null)
    {
        $titulo = $titulo ?? $request->input('titulo', '');
        $tema = $tema ?? $request->input('tema', '');

        $noticias = Noticia::where('titulo', 'LIKE', '%' . $titulo . '%')
            ->where('tema', 'LIKE', "%$tema%")
            ->paginate(9)
            ->appends(['titulo' => $titulo, 'tema' => $tema]);

        return view('noticias.list', [
            'noticias' => $noticias,
            'titulo' => $titulo,
            'tema' => $tema
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Noticia::class);
        // mostrar formulario
        return view('noticias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoticiaRequest $request)
    {
        $datos = $request->only([
            'titulo', 'tema', 'texto'
        ]);

        $datos += ['visitas' => 0];
        $datos += ['published_at' => null];
        $datos += ['rejected' => false];
        $datos['imagen'] = NULL;

        if ($request->hasFile('imagen')) {
            //sube la imagen al directorio indicando en el fichero de config
            $ruta = $request->file('imagen')->store(config('filesystems.noticiasImageDir'));
            //nos quedamos solo con el nombre del fichero para añadirlo a la BDD
            $datos['imagen'] = pathinfo($ruta, PATHINFO_BASENAME);
        }

        $datos['user_id'] = $request->user()->id;

        Noticia::create($datos);

        return redirect()->route('noticias.index')->with('success', 'Noticia creada exitosamente.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Recupera la noticia con el id deseado, generando un error 404 si no la encuentra
        $noticia = Noticia::findOrFail($id);

        // Incrementa el contador de visitas
        $noticia->increment('visitas');

        // Carga la vista correspondiente y le pasa la noticia
        return view('noticias.show', ['noticia' => $noticia]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Noticia $noticia)
    {
        return view('noticias.update', [
            'noticia' => $noticia
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\NoticiaUpdateRequest  $request
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function update(NoticiaUpdateRequest $request, Noticia $noticia)
    {
        $datos = $request->only([
            'titulo', 'tema', 'texto'
        ]);

        // si llega nueva imagen...
        if ($request->hasFile('imagen')) {
            // Borra la imagen anterior si existe
            if ($noticia->imagen)
                $aBorrar = config('filesystems.noticiasImageDir') . '/' . $noticia->imagen;

            // sube la imagen al directorio indicado en el fichero de config
            $imagenNueva = $request->file('imagen')->store(config('filesystems.noticiasImageDir'));

            // nos quedamos solo con el nombre del fichero para añadirlo a la BDD
            $datos['imagen'] = pathinfo($imagenNueva, PATHINFO_BASENAME);
        }

        // en caso de que nos pidan eliminar la imagen
        if ($request->filled('eliminarimagen') && $noticia->imagen) {
            $datos['imagen'] = NULL;
            $aBorrar = config('filesystems.noticiasImageDir') . '/' . $noticia->imagen;
        }

        // al actualizar debemos tener en cuenta varias cosas
        if ($noticia->update($datos)) {
            if (isset($aBorrar))
                Storage::delete($aBorrar);
        } else {
            if (isset($imagenNueva))
                Storage::delete($imagenNueva);
        }

        return redirect()->route('noticias.index')->with('success', 'Noticia actualizada exitosamente.');
    }


    public function delete(Request $request, Noticia $noticia)
    {
        //autorización mediante policy
        if ($request->user()->cant('delete', $noticia))
            abort(401, 'No puedes borrar una noticia que no es tuya!');

        //muestra la vista de confirmación de eliminación
        return view('noticias.delete', [
            'noticia' => $noticia
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Noticia $noticia)
    {
        //autorización mediante policy
        if ($request->user()->cant('delete', $noticia))
            abort(401, 'No puedes borrar una noticia que no es tuya!');

        //comporbar la validez de la firma de la URL
        if (!$request->hasValidSignature())
            abort(401, 'La firma de la URL no s epudo validar');

        // la borra de la base de datos
        $noticia->delete();

        //redirige a la lista de motos
        return redirect()->route('noticias.index')
            ->with('success', 'La noticia ha sido eliminada');
    }

    /**
     * Summary of restore
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request, int $id)
    {
        // Recuperar la noticia borrada
        $noticia = Noticia::withTrashed()->findOrFail($id);

        // Verificar permisos usando la política de restauración
        if ($request->user()->cant('restore', $noticia)) {
            throw new AuthorizationException('No tienes permiso');
        }

        // Restaurar la moto
        $noticia->restore();

        // Redirigir a la página anterior con un mensaje de éxito
        return back()->with('success', "Noticia $noticia->titulo restaurada correctamente.");
    }

    /**
     * Summary of purge
     * @param \Illuminate\Http\Request $request
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function purge(Request $request)
    {
        //recuperar la noticia borrada
        $noticia = Noticia::withTrashed()->findOrFail($request->input('noticia_id'));

        //comprobar los permisos mediante la policy
        if ($request->user()->cant('delete', $noticia))
            throw new AuthorizationException('No tienes permiso');

        // si se consigue eliminar definitivamente la noticia y ésta tiene foto...
        if ($noticia->forceDelete() && $noticia->imagen)
            // ... se elimina el fichero
            Storage::delete(config('filesystems.noticiasImageDir') . '/' . $noticia->imagen);

        return back()->with(
            'success',
            "Noticia $noticia->titulo eliminada definitivamente."
        );
    }

    /**
     * Método para mostrar las noticias del usuario
     */
    public function userNoticias()
    {
        $user = Auth::user();
        $noticias = Noticia::where('user_id', $user->id)->get();
        $deletedNoticias = Noticia::onlyTrashed()->where('user_id', $user->id)->get();

        return view('home', [
            'user' => $user,
            'noticias' => $noticias,
            'deletedNoticias' => $deletedNoticias
        ]);
    }

    /**
     * Listar noticias pendientes.
     */
    public function pendientes()
    {
        $this->authorize('viewPending', Noticia::class);

        $noticiasPendientes = Noticia::whereNull('published_at')
            ->where('rejected', false)
            ->get();

        return view('noticias.pendientes', ['noticias' => $noticiasPendientes]);
    }


    /**
     * Aprobar noticia.
     */
    public function aprobar(Request $request, Noticia $noticia)
    {
        $this->authorize('approve', $noticia);

        $noticia->update(['published_at' => now(), 'rejected_at' => null]);

        return redirect()->route('noticias.pendiente')->with('success', 'Noticia aprobada y publicada.');
    }

    /**
     * Rechazar noticia.
     */
    public function rechazar(Request $request, Noticia $noticia)
    {
        $this->authorize('reject', $noticia);

        $noticia->update(['rejected_at' => now()]);

        return redirect()->route('noticias.pendiente')->with('success', 'Noticia rechazada.');
    }
}
