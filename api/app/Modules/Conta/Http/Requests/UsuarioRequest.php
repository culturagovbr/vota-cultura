<?php

namespace App\Modules\Conta\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'no_cpf' => 'required|string',
            'no_email' => 'required|string',
            'ds_senha' => 'required|string',
            'dt_nascimento' => 'required|string',
            'dt_cadastro' => 'required|string',
            'st_ativo' => 'required',
        ];
    }
}
