<?php namespace App\Http\Request\Accounts;

use App\Http\Requests\Request;

class updateShippingInfo extends Request
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
            'county_id' => 'required',
            'town' => 'required',
            'home_address' => 'required'
        ];
    }

}
