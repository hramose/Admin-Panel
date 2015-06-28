<?php

namespace Cinject\AdminPanel\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;

class PermissionRequest extends Request
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
            'name'=>'required|unique:'.config('entrust.permissions_table'),
            'display_name'=>'required|max:255',
            'description'=>'string',
        ];

        switch($this->method()) {
            case 'PATCH':
                $rules['name'] = 'required|unique:'.config('entrust.permissions_table').',name,'.$this->permission->id;
                break;
        }

        return $rules;
    }
}
