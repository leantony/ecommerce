<?php namespace App\Http\Requests\Checkout;

use App\Http\Requests\Request;

class paymentDataRequest extends Request
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
            'cardName' => 'required|alpha_dash|between:1,30',
            'cardNumber' => 'required|numeric'
        ];
    }

}
