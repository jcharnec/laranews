<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaApiController extends Controller
{
    /**
     * Summary of index
     * método que recupera todas las noticias y las retorna en JSON
     * @return array
     */
    public function index()
    {
        //recupera todas las noticias ordenadas opr id DESC
        //para orden por defecto podemos usar Noticias::all()
        $noticias = Noticia::orderBy('id', 'DESC')->get();

        return [
            'status' => 'OK',
            'total' => count($noticias),
            'results' => $noticias
        ];
    }

    /**
     * Summary of show
     * método que muestra una moto a parti de su ID
     * @param mixed $id
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id)
    {
        //no usaremos un findOrFail ni un implicit binding puesto
        //que queremos personalizar el error en caso de que se produzca
        $noticia = Noticia::find($id);

        return $noticia ?
            [
                'status' => 'OK',
                'results' => [$noticia]
            ] :
            response(['status' => 'NOT FOUND'], 404);
    }

    /**
     * Summary of search
     * método que busca noticias y retorna un JSON
     * @param mixed $campo
     * @param mixed $valor
     * @return array
     */
    public function search($campo = 'titulo', $valor = '')
    {
        // Recupera las noticias con los criterios especificados
        $noticias = Noticia::where($campo, 'like', "%$valor%")->get();

        return response()->json([
            'status' => 'OK',
            'total' => count($noticias),
            'results' => $noticias
        ]);
    }

    /**
     * Summary of store
     * método que crea una nueva noticia
     * NOTA 1: no se podrá subir una imagen vía JSON
     * NOTA 2: mientras no se implemente la autorización, el user_id será null
     * NOTA 3: versión sin validación de datos (la añadiremos luego)
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request){
        $datos = $request->json()->all();
        $datos['visitas'] = 0;
        $datos['imagen'] = NULL;
        $datos['user_id'] = NULL;

        $noticia = Noticia::create($datos);

        return $noticia ? 
            response([
                'status' => 'OK',
                'results' => [$noticia]
            ], 201):
            response([
                'status' => 'ERROR',
                'message' => 'No se pudo guardar la noticia'
            ], 400);
    }

    /**
     * Summary of update
     * método que actualiza una noticia
     * NOTA: versión sin validación, la añadiremos después
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $noticia = Noticia::find($id);

        if(!$noticia)
            return response(['status' => 'NOT FOUND'], 404);

        $datos = $request->json()->all();

        return $noticia->update($datos) ?
            response([
                'status' => 'OK',
                'results' => [$noticia]
            ], 200):
            response([
                'status' => 'ERROR',
                'message' => 'No se pudo actualizar la noticia'
            ],400);
    }

    /**
     * Summary of delete
     * método que borra una noticia
     * @param mixed $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function delete($id){
        $noticia = Noticia::find($id);

        if(!$noticia)
            return response(['status' => 'NOT FOUND'], 404);

        return $noticia->delete() ?
            response(['status' => 'OK']) :
            response([
                'status' => 'ERROR', 
                'message' => 'No se pudo eliminar la noticia'
            ],400);
    }
}
