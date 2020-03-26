<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGroupRequest extends FormRequest
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
            'name'      => 'required|unique:groups,name',
            'branch'    =>  'required|integer|min:1',
            'fee'       =>  'required|numeric|min:1',
        ];
    }

    public function attributes()
    {
        return [
            'name'      =>  'Nombre',
            'branch'    =>  'Total Registros por Patrocinador',
            'fee'       =>  'Cuota'
        ];
    }
}
