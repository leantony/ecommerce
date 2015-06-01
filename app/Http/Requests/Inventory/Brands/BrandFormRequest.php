<?php namespace App\Http\Requests\Inventory\Brands;

use App\Http\Requests\Request;

class BrandFormRequest extends Request
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
            'name' => 'required|alpha_dash|between:2,15|unique:brands',
            'logo' => 'required|mimes:png|between:1,1000',
        ];

        if ($this->isMethod('PATCH')) {
            $rules['name'] = 'required|alpha_dash|between:2,15|unique:brands,id,' . $this->get('id');
            $rules['logo'] = 'sometimes|mimes:png|between:1,1000|unique:brands,id,' . $this->get('id');
        }

        return $rules;
    }

}
