<?php namespace App\Http\Requests\Accounts;

use App\Http\Requests\Request;

class addMoreAccountInfo extends Request
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
        if ($this->isMethod('patch')) {
            return [
                'avatar' => 'sometimes|required|image|between:4,3000',
                'dob' => 'sometimes|required|date',
                'gender' => 'sometimes|required|in:Male,Female',
            ];
        }
    }


    public function Messages()
    {
        return [
            'avatar.required' => 'You need to upload your profile picture (avatar)',
            'gender.required' => 'You need to select your gender',
            'dob.required' => 'You need to provide your date of birth',
            'dob.date' => 'You provided an invalid date of birth',
            'dob.date_format' => 'Please provide your date of birth in the format specified (yyyy-mm-dd)'
        ];
    }

}
