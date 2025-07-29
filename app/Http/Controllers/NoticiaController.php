<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class NoticiaController extends Controller
{
    /**
     * Aplica middlewares.
     */
    public function __construct()
    {
        // Requiere email verificado para todo excepto listar/ver/buscar
        $this->middleware(['verified'])->except('index', 'show', 'search');

        // Confirmación de contraseña para destruir
        $this->middleware('password.confirm')->only('destroy');
    }

    /**
     * Listado de noticias (público).
     */
    public function index(Request $request)
    {
        $noticias = Noticia::orderByDesc('id')->paginate(9);
        $total    = Noticia::count();

        return View::make('noticias.list', [
            'noticias' => $noticias,
            'total'    => $total,
        ]);
    }

    /**
     * Búsqueda de noticias (público).
     */
    public function search(Request $request, $titulo = null, $tema = null)
    {
        $titulo = $titulo ?? $request->input('titulo', '');
        $tema   = $tema   ?? $request->input('tema', '');

        $noticias = Noticia::when($titulo !== '', fn($q) => $q->where('titulo', 'LIKE', "%{$titulo}%"))
            ->when($tema !== '', fn($q) => $q->where('tema', 'LIKE', "%{$tema}%"))
            ->orderByDesc('id')
            ->paginate(8)
            ->appends(['titulo' => $titulo, 'tema' => $tema]);

        $total = Noticia::count();

        return view('noticias.list', compact('noticias', 'titulo', 'tema', 'total'));
    }

    /**
     * Formulario de creación (requiere login verificado).
     */
    public function create()
    {
        $temas = ['Actualidad', 'Política', 'Deportes', 'Cultura', 'Tecnología', 'Economía', 'Opinión'];
        return view('noticias.create', compact('temas'));
    }

    /**
     * Guardar nueva noticia (requiere login verificado).
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'tema'   => 'required|max:255',
            'texto'  => 'required',
            'imagen' => 'nullable|image',
        ]);

        $noticia = new Noticia();
        $noticia->titulo       = $request->titulo;
        $noticia->tema         = $request->tema;
        $noticia->texto        = $request->texto;
        $noticia->visitas      = 0;
        $noticia->published_at = null;
        $noticia->rejected     = false;
        $noticia->user_id      = auth()->id(); // 👈 dueño

        if ($request->hasFile('imagen')) {
            // guarda en storage/app/public/images/noticias
            $path = $request->file('imagen')->store('images/noticias', 'public');
            // guardamos la ruta relativa (p.ej. images/noticias/archivo.jpg)
            $noticia->imagen = $path;
        }

        $noticia->save();

        return redirect()->route('noticias.index')->with('success', 'Noticia creada exitosamente.');
    }

    /**
     * Ver detalles (público).
     */
    public function show($id)
    {
        $noticia = Noticia::findOrFail($id);

        // (Opcional) incrementar visitas:
        // $noticia->increment('visitas');

        return view('noticias.show', compact('noticia'));
    }

    /**
     * Formulario de edición (dueño o admin).
     */
    public function edit($id)
    {
        $noticia = Noticia::findOrFail($id);

        if (!$this->canManage($noticia)) {
            abort(403, 'No tienes permisos para editar esta noticia.');
        }

        // Si quieres reutilizar el selector de temas:
        $temas = ['Actualidad', 'Política', 'Deportes', 'Cultura', 'Tecnología', 'Economía', 'Opinión'];

        return view('noticias.edit', compact('noticia', 'temas'));
    }

    /**
     * Actualizar noticia (dueño o admin).
     */
    public function update(Request $request, $id)
    {
        $noticia = Noticia::findOrFail($id);

        if (!$this->canManage($noticia)) {
            abort(403, 'No tienes permisos para actualizar esta noticia.');
        }

        $request->validate([
            'titulo' => 'required|max:255',
            'tema'   => 'required|max:255',
            'texto'  => 'required',
            'imagen' => 'nullable|image',
        ]);

        $noticia->titulo = $request->titulo;
        $noticia->tema   = $request->tema;
        $noticia->texto  = $request->texto;

        if ($request->hasFile('imagen')) {
            // Si hay imagen previa, la borramos (si no es null)
            if ($noticia->imagen) {
                Storage::disk('public')->delete($noticia->imagen);
            }

            $path = $request->file('imagen')->store('images/noticias', 'public');
            $noticia->imagen = $path; // ruta relativa
        }

        $noticia->save();

        return redirect()
            ->route('noticias.show', $noticia->id)
            ->with('success', 'Noticia actualizada correctamente.');
    }

    /**
     * Confirmación de borrado (muestra vista).
     */
    public function delete($id)
    {
        $noticia = Noticia::findOrFail($id);

        if (!$this->canManage($noticia)) {
            abort(403, 'No tienes permisos para eliminar esta noticia.');
        }

        return view('noticias.delete', compact('noticia'));
    }

    /**
     * Borrar noticia (dueño o admin).
     */
    public function destroy($id)
    {
        $noticia = Noticia::findOrFail($id);

        if (!$this->canManage($noticia)) {
            abort(403, 'No tienes permisos para eliminar esta noticia.');
        }

        // Borra imagen asociada si existe
        if ($noticia->imagen) {
            Storage::disk('public')->delete($noticia->imagen);
        }

        $noticia->delete();

        return redirect()->route('noticias.index')
            ->with('success', 'La noticia ha sido eliminada');
    }

    /**
     * Helper de autorización: dueño o admin.
     */
    private function canManage(Noticia $noticia): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        // Dueño de la noticia o rol administrador
        return $user->id === $noticia->user_id || $user->hasRole('administrador');
    }
}
