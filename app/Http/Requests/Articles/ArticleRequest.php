<?php namespace App\Http\Requests\Articles;

use App\Http\Requests\Request;

class ArticleRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return is_null($this->user()) ? false : true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'topic' => 'required|between:5,50',
            'content' => 'required'
        ];
    }

}
