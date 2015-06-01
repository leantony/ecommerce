<?php namespace App\Http\Requests\Accounts;

use App\Http\Requests\Request;

class ContactInfo extends Request
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
            'email' => 'required|email|max:255|unique:users,id,' . $this->user()->id,
            'phone' => 'required|digits:9|unique:users,id,' . $this->user()->id,
        ];
    }

}
