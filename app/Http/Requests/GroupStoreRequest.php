<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupStoreRequest extends FormRequest
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
            'name' => 'required|string|unique:groups,name'
        ];
    }

    public function messages()
    {
        return[
            'name.required'=> 'Informe o nome do grupo',
            'name.string' => 'O campo nome deve ser do tipo string',
            'name.unique' => 'Já existe um grupo com este nome'
        ];
    }
}
