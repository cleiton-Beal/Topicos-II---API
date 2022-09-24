<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCliente extends FormRequest
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
            'id'        => 'nullable',
            'nome'      => 'required|min:5',
            'cpfCnpj'   => 'required',
            'telefone'  => 'required|min:11',
            'email'     => 'required|email',
            'email_confirmation' => 'required|email',
        ];
    }
}
