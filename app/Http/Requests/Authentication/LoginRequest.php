<?php namespace App\Http\Requests\Authentication;

use App\Http\Requests\Request;

class LoginRequest extends Request
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
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'sometimes|required|recaptcha',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'email.required' => 'Please enter your email address',
            'password.required' => 'Please enter your password',
            'email.email' => 'The email entered is not a valid email address',
            'g-recaptcha-response.required' => 'You need to solve the recaptcha',
        ];
    }

}
