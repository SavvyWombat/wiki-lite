<?php

namespace SavvyWombat\WikiLite\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SavePage extends FormRequest
{
    /**
     * Redirect route when errors occur.
     *  
     * @var string
     */
    protected $redirectRoute = 'wiki-lite.edit';

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
            'title' => [
                'required',
            ],
            'content' => [
                'required',
            ],
            'uuid' => [
                'sometimes',
                'regex:/[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}/',
            ],
            'parent_uuid' => [
                'sometimes',
                'regex:/[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}/',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'All pages must have a unique title',
            'content.required' => 'A wiki page must have content',
            'uuid.regex' => 'Valid UUID for the page must be provided',
            'parent_uuid.regex' => 'Valid UUID for the page must be provided',
        ];
    }
}