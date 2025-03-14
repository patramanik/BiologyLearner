<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFormRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:200'
            ],
            'mataTile' => [

                'max:200'
            ],
            'image' => [
                'required',
                'mimes:jpeg,jpg,png'
            ],
            'description' => [
                
            ],
            'keywords' => [],
        ];
        if ($this->isMethod('post')) {
            $rules['image'] = [
                'required',
                'mimes:jpeg,jpg,png'
            ];
        } else {
            $rules['image'] = [
                'nullable',
                'mimes:jpeg,jpg,png'
            ];
        }
        return $rules;
    }
}
