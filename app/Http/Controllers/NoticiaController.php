<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\User;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class NoticiaController extends Controller
{
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
        $noticias = Noticia::with('user')
            ->orderByDesc('id')
            ->paginate(9);

        $total = Noticia::count();

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

        $noticias = Noticia::with('user')
            ->when($titulo !== '', fn($q) => $q->where('titulo', 'LIKE', "%{$titulo}%"))
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
        $noticia->user_id      = auth()->id();

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = Str::uuid() . '.' . $file->extension();
            // Guarda en storage/app/public/images/noticias
            $file->storeAs('images/noticias', $filename, 'public');
            // En BD guardamos SOLO el nombre (convención)
            $noticia->imagen = $filename;
        }

        $noticia->save();

        return redirect()
            ->route('noticias.index')
            ->with('success', 'Noticia creada exitosamente.');
    }

    /**
     * Mostrar detalle + comentarios paginados (público).
     */
    public function show($id)
    {
        $noticia = Noticia::with('user')->findOrFail($id);

        // Paginamos los comentarios (con su autor)
        $comentarios = $noticia->comentarios()
            ->with('user')
            ->latest()
            ->paginate(5);

        // Sumar visita
        $noticia->increment('visitas');

        return view('noticias.show', compact('noticia', 'comentarios'));
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
            // Borrar la previa (sea nombre suelto o ruta vieja con 'images/noticias/...'):
            if ($noticia->imagen) {
                $old = $this->noticiaImageDiskPath($noticia->imagen); // relativo al disco 'public'
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }

            $file = $request->file('imagen');
            $filename = Str::uuid() . '.' . $file->extension();
            $file->storeAs('images/noticias', $filename, 'public');

            // Guardamos solo el nombre
            $noticia->imagen = $filename;
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
     * Borrar noticia (soft delete) y su imagen en disco.
     */
    public function destroy($id)
    {
        $noticia = Noticia::findOrFail($id);

        if (!$this->canManage($noticia)) {
            abort(403, 'No tienes permisos para eliminar esta noticia.');
        }

        if ($noticia->imagen) {
            $path = $this->noticiaImageDiskPath($noticia->imagen);
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $noticia->delete();

        return redirect()
            ->route('noticias.index')
            ->with('success', 'La noticia ha sido eliminada');
    }

    /**
     * Publicar comentario (requiere login verificado).
     */
    public function storeComentario(Request $request, Noticia $noticia)
    {
        $request->validate([
            'texto' => 'required|string|min:3|max:2000',
        ]);

        $comentario = new Comentario([
            'texto'      => $request->input('texto'),
            'user_id'    => auth()->id(),
            'noticia_id' => $noticia->id,
        ]);

        $comentario->save();

        return back()->with('success', 'Comentario publicado.');
    }

    /**
     * Helper de autorización: dueño o admin.
     */
    private function canManage(Noticia $noticia): bool
    {
        /** @var User|null $user */
        $user = auth()->user();

        if (!$user instanceof User) {
            return false;
        }

        return $user->id === $noticia->user_id || $user->hasRole('administrador');
    }

    /**
     * Normaliza la ruta de la imagen de noticia relativa al disco 'public'.
     * Acepta tanto nombres sueltos ("archivo.jpg") como rutas antiguas ("images/noticias/archivo.jpg").
     */
    private function noticiaImageDiskPath(?string $imagen): ?string
    {
        if (!$imagen) return null;

        return Str::startsWith($imagen, 'images/')
            ? $imagen
            : 'images/noticias/' . $imagen;
    }
}
