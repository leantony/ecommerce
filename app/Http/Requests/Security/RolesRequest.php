<?php namespace App\Http\Requests\Security;

use App\Http\Requests\Request;


class RolesRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * Only admins will be allowed to create roles
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasRole('Administrator');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|alpha_dash|between:2,30|unique:roles',
            'display_name' => 'between:3,30',
            'description' => 'between:3,200',
            'permissions' => 'array'
        ];

        if ($this->isMethod('patch')) {

            $rules['name'] = 'required|alpha_dash|between:2,30|unique:roles,id,' . $this->get('id');
        }

        return $rules;
    }

}
