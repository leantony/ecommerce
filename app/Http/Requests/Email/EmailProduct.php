<?php namespace App\Http\Requests\Products;

use App\Http\Requests\Request;

class EmailProduct extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|array',
            'message' => 'required|between:5,500',
            'g-recaptcha-response' => 'sometimes|required|recaptcha',
        ];
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.required' => 'Please solve the recaptcha',
            'message.required' => 'Please enter a message',
            'email.required' => 'Your email address is required',
        ];
    }

}
