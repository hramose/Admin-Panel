<?php

namespace Cinject\AdminPanel\Requests;


use Illuminate\Foundation\Http\FormRequest as Request;

class RoleRequest extends Request
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
        $rules = [
            'name'=>'required|unique:'.config('entrust.roles_table'),
            'display_name'=>'required|max:255',
            'description'=>'string',
        ];

        switch($this->method()) {
            case 'PATCH':
                $rules['name'] = 'required|unique:'.config('entrust.roles_table').',name,'.$this->role->id;
                break;
        }

        return $rules;
    }
}
