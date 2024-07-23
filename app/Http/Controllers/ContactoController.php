<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;

class ContactoController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        return view('contacto');
    }

    /**
     * Summary of send
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Request $request){
        $request->validate([
            'email' => 'required|email:rfc',
            'fichero' => 'sometimes|file|mimes:pdf'
        ]);

        $mensaje = new \stdClass();
        $mensaje->asunto = $request->asunto;
        $mensaje->email = $request->email;
        $mensaje->nombre = $request->nombre;
        $mensaje->mensaje = $request->mensaje;

        // si en envió fichero recupera la ruta ( en el directorio temporal)
        $mensaje->fichero = $request->hasFile('fichero')?
                            $request->file('fichero')->getRealPath():NULL;
        
        Mail::to('contacto@larabikes.com')->send(new Contact($mensaje));

        return redirect()->route('welcome')->with('success', 'Mensaje enviado correctamente.');

    }
}
