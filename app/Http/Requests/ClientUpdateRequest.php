<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'name' => 'string',
            'cnpj' => 'string|min:14|max:14|unique:clients,cnpj,'.$id,
            'foundation' => 'date',
            'group_id' => 'int'
        ];

    }

    public function messages(): array
    {
        return [
         
            'name.string' => 'O campo nome deve ser do tipo string',            
            'cnpj.string' => 'O campo cnpj deve ser do tipo string',
            'cnpj.min' => 'O campo cnpj deve conter 14 caracteres',
            'cnpj.unique' => 'Já existe outro cliente com este cnpj',
            'foundation.date' => 'O campo foundation deve ser do tipo date',
            'group_id.int' => 'O campo group_id deve ser do tipo inteiro'
        ];
    }
}
