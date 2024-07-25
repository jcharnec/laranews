<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticiaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'titulo' => 'required|max:255',
            'tema' => 'required|max:255',
            'texto' => 'required',
            'imagen' => 'sometimes|file|image|mimes:jpg,png,gif,webp|max:2048',
        ];
    }

    public function messages(){
        return[
            'titulo.required' => 'El titulo es requerido',
            'tema.required' => 'El tema es requerido',
            'texto.required' => 'El texto es requerido',
            'imagen.image' => 'La imagen debe ser una imagen',
            'imagen.mimes' => 'La imagen debe ser de tipo jpg, png, gif o web.',
        ];
    }
}
