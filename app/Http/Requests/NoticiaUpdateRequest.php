<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class NoticiaUpdateRequest extends NoticiaRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->noticia->id;
        return [
            //
        ]+parent::rules();
    }

    /**
     * Summary of authorize
     * @return mixed
     */
    public function authorize(){
        return $this->user()->can('update', $this->noticia);
    }

    /**
     * Summary of failedAuthorization
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return never
     */
    protected function failedAuthorization(){
        throw new AuthorizationException('No puedes editar una noticia que no es tuya.');
    }
}
