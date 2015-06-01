<?php namespace App\Http\Requests\Inventory\SubCategories;

use App\Http\Requests\Request;

class SubCategoryRequest extends Request
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
            'name' => 'required|unique:subcategories',
            'alias' => 'alpha',
            'banner' => 'image|between:5,2000',
            'category_id' => 'required'
        ];

        if ($this->isMethod('patch')) {

            $rules['name'] = 'required|unique:subcategories,id,' . $this->get('id');
        }

        return $rules;
    }

}
