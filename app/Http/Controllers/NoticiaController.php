<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;
use Illuminate\Support\Facades\View;

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
        $total = Noticia::count();

        return View::make('noticias.list', [
            'noticias' => $noticias, 
            'total' => $total,
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
            ->paginate(8)
            ->appends(['titulo' => $titulo, 'tema' => $tema]);

        $total = Noticia::count();

        return view('noticias.list', [
            'noticias' => $noticias,
            'titulo' => $titulo,
            'tema' => $tema,
            'total' => $total
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // mostrar formulario
        return view('noticias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'tema' => 'required|max:255',
            'texto' => 'required',
            'imagen' => 'nullable|image',
        ]);
    
        $noticia = new Noticia();
        $noticia->titulo = $request->titulo;
        $noticia->tema = $request->tema;
        $noticia->texto = $request->texto;
        $noticia->visitas = 0; // Inicializa visitas a 0
        $noticia->published_at = null; // Dejar null hasta que sea revisada
        $noticia->rejected = false; // Inicializa rejected a false
    
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('public/images/noticias');
            $noticia->imagen = basename($path);
        }
    
        $noticia->save();
    
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
        //recupera la noticia con el id deseado
        //si no la recuera generará un error 404
        $noticia = Noticia::findOrFail($id);

        //carga la vista correspondiente y le pasa la noticia
        return view('noticias.show', ['
            noticia' => $noticia
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //recupera la noticia con el id deseado
        //si no la recuera generará un error 404
        $noticia = Noticia::findOrFail($id);

        //carga la vista correspondiente y le pasa la noticia
        return view('noticias.update', [
            'noticia', $noticia
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function delete($id)
    {
        //recupera la noticia
        $noticia = Noticia::findOrFail($id);

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
    public function destroy($id)
    {
        //busca la noticia seleccionada
        $noticia = Noticia::findOrFail($id);

        // la borra de la base de datos
        $noticia->delete();

        //redirige a la lista de motos
        return redirect()->route('noticias.index')
            ->with('success', 'La noticia ha sido eliminada');
    }
}
