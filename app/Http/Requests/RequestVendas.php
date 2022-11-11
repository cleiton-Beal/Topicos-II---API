<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestVendas extends FormRequest
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
            'cliente' => 'nullable|integer',
            'produtos' => 'array|required',
            'produtos.*.id' => 'required',
            'produtos.*.quantidade' => 'required',
            'produtos.*.valorProduto' => 'required',
            'produtos.*.nomeProduto'  => 'required'
        ];
    }
}
