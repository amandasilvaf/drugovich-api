<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupUpdateRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'unique:groups,name,'.$id,
            ],
        ];
    }

    public function messages()
    {
        return[
            'name.required'=> 'Informe o novo nome do grupo',
            'name.string' => 'O campo nome deve ser do tipo string',
            'name.unique' => 'Já existe um grupo com este nome'
        ];
    }
}
