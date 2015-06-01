<?php namespace App\Http\Requests\Security;

use App\Http\Requests\Request;

class PermissionsRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasRole('Administrator') and $this->user()->can('configure security');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|between:3,100|unique:permissions',
            'display_name' => 'required|between:3,50',
            'description' => 'required|between:3,255',
        ];

        if ($this->isMethod('patch')) {
            $rules['name'] = 'required|unique:permissions,id,' . $this->get('id');
        }

        return $rules;
    }

}
