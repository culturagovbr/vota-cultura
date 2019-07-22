<?php

namespace App\Modules\Conta\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{

    public function rules()
    {
        return [
            'ds_email' => 'required|string',
            'ds_senha' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo ":attribute" é obrigatório!',
            'date' => 'Data inválida!',
        ];
    }
}
