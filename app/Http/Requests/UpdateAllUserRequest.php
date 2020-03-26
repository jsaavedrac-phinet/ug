<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAllUserRequest extends FormRequest
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
            'full_name'             =>  'required',
            'dni'                   =>  'required|integer|unique:users,dni,'.$this->request->get('id'),
            'phone'                 =>  'required|integer|unique:users,phone,'.$this->request->get('id'),
            'user'                  =>  'required',
            'password'              =>  'required',
            'bank_account_number'   =>  'required|unique:users,bank_account_number,'.$this->request->get('id'),
            'role'                  =>  'required',
            'group_id'              =>  'required_if:role,admin'
        ];
    }
    public function attributes()
    {
        return [
            'full_name'             =>  'Nombre Completo',
            'dni'                   =>  'DNI',
            'phone'                 =>  'Teléfono',
            'user'                  =>  'Usuario',
            'password'              =>  'Clave',
            'bank_account_number'   =>  'Cuenta Bancaria',
            'role'                  =>  'Rol',
            'group_id'              =>  'Grupo'
        ];
    }
}
