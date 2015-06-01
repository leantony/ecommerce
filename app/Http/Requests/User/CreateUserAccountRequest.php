<?php namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class CreateUserAccountRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->isMethod('PATCH') ? $this->user() !== null : true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required|alpha|between:2,15',
            'last_name' => 'required|alpha|between:2,15',
            'phone' => 'required|digits:9|unique:users',
            'county_id' => 'required|numeric',
            'home_address' => 'required|between:3,50',
            'town' => 'required|between:3,15',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'dob' => 'sometimes|required|date',
            'avatar' => 'sometimes|image|between:4,3000',
            'accept' => 'required',
            'g-recaptcha-response' => 'sometimes|required|recaptcha',
        ];

        if ($this->segment(1) === 'backend') {
            $rules['accept'] = '';
        }

        if ($this->isMethod('patch')) {

            $rules['email'] = 'required|email|max:255|unique:users,id,' . $this->user()->id;
            $rules['accept'] = '';
            $rules['phone'] = 'required|digits:9|unique:users,id,' . $this->user()->id;
            $rules['password'] = 'sometimes|confirmed|min:6' . $this->user()->id;
        }

        return $rules;
    }

    public function Messages()
    {
        return [
            'g-recaptcha-response.required' => 'You need to solve the recaptcha',
            'accept.required' => 'You need to accept our terms of service',
            'email.unique' => 'That email belongs to another user',
            'phone.unique' => 'That phone number belongs to another user'
        ];
    }

}
