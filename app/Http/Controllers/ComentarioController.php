<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Noticia;
use App\Http\Requests\ComentarioRequest;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComentarioRequest $request, Noticia $noticia)
    {
        $request->user()->comentarios()->create([
            'texto' => $request->texto,
            'noticia_id' => $noticia->id,
        ]);

        return redirect()->route('noticias.show', $noticia->id)->with('success', 'Comentario añadido correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Comentario $comentario)
    {
        $this->authorize('update', $comentario);

        return view('comentarios.edit', compact('comentario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComentarioRequest $request, Comentario $comentario)
    {
        $this->authorize('update', $comentario);

        $comentario->update($request->only('texto'));

        return redirect()->route('noticias.show', $comentario->noticia_id)->with('success', 'Comentario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comentario $comentario)
    {
        $this->authorize('delete', $comentario);

        $comentario->delete();

        return back()->with('success', 'Comentario eliminado correctamente.');
    }
}