<?php namespace App\Http\Requests\Security;

use App\Http\Requests\Request;

class AssignRolesRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * Only Admins will be allowed to assign roles to other users
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
        return [
            // using an array will allow an admin to assign multiple roles to a user
            'role_id' => 'required|array',
            'user_id' => 'required|exists:users,id'
        ];
    }

}
