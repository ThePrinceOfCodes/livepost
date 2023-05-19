<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['string','required'],
            'body' =>  ['string','required'],
            'user_ids' => [
                'array',
                'required', 
                function($attribute, $value, $fail){
                    $integerOnly = collect($value)->every(fn ($element) => is_int($element));

                    if(!$integerOnly){
                        $fail($attribute.'array value should only be integer');
                    }
                }
            ]
        ];
    }

    public function messages()
    {
        return [
            'body.required' => "please enter a value for body"
        ];
    }
}
