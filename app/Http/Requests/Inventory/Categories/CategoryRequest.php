<?php namespace App\Http\Requests\Inventory\Categories;

use App\Http\Requests\Request;

class CategoryRequest extends Request
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
            'name' => 'required|between:3,50|unique:categories',
            'alias' => 'alpha_dash|between:3,50',
            'banner' => 'image|between:5,2000',
        ];

        if ($this->isMethod('PATCH')) {
            $rules['name'] = 'required|between:3,50|unique:categories,id,' . $this->get('id');
        }

        return $rules;
    }

}
