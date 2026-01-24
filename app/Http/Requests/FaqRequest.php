<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'question' => [
                'required',
                'string',
                'max:255'
            ],
            'answer' => [
                'required',
                'string',
                'max:255'
            ]
        ];
    }


    public function messages()
    {
        return [

            'question.required' => 'يجب ادخال السؤال',
            'question.string' => 'يجب ادخال نص في السؤال',
            'question.max' => 'يجب الا يزيد السؤال عن 255 حرف',

            'answer.required' => 'يجب ادخال الاجابة',
            'answer.string' => 'يجب ادخال نص في الاجابة',
            'answer.max' => 'يجب الا يزيد الاجابة عن 255 حرف',

        ];
    }
}
