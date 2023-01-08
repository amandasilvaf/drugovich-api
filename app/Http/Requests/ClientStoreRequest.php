<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ClientStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'cnpj' => [
                'required',
                'string',
                'min:14',
                'max:14',
                'unique:clients,cnpj'
            ],
            'foundation' => [
                'required',
                'date'
            ],
            'group_id' => 'int'
        ];

    }

    public function messages(): array
    {
        return [
            'name.required'=> 'Informe o nome do cliente',
            'name.string' => 'O campo nome deve ser do tipo string',
            'cnpj.required' => 'Informe o cnpj',
            'cnpj.string' => 'O campo cnpj deve ser do tipo string',
            'cnpj.min' => 'O campo cnpj deve conter 14 caracteres',
            'cnpj.unique' => 'Já existe um cliente com este cnpj',
            'foundation.required' => 'Informe a data da fundação',
            'foundation.date' => 'O campo foundation deve ser do tipo date',
            'group_id.int' => 'O campo group_id deve ser do tipo inteiro'
        ];
    }
}
