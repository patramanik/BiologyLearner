<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'catagory_id' =>[
                'required'
            ],
            'post_name' =>[
                'required',
                'string',
                'max:200'
            ],
            'metaTile' =>[
                'required',
                'string',
                'max:200'
            ],
            'image' =>[
                'required',
                'mimes:jpeg,jpg,png'
            ],
            'Post_keywords' =>[
                'required',
                'string'
            ],
            'Post_Content' =>[
                'required',
                'string'
            ],

        ];
        return $rules;
    }
}
