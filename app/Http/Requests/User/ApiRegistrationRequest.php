<?php namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class ApiRegistrationRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->session()->has('api_user_data');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|confirmed|min:6',
            'accept' => 'required',
        ];
    }

}
