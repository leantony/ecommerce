<?php namespace App\Http\Requests\Checkout;

use App\Http\Requests\Request;

class GuestCheckoutRequest extends Request
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
        return [
            'first_name' => 'required|alpha|between:2,15',
            'last_name' => 'required|alpha|between:2,15',
            'phone' => 'required|digits:9',
            'county_id' => 'required|numeric',
            'home_address' => 'required|between:3,50',
            'town' => 'required|between:3,15',
            'email' => 'required|email|max:255',
        ];
    }

}
