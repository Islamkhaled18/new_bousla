<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutUsRequest extends FormRequest
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
            'text'    => 'required|string|max:500',
            'text_en' => 'nullable|string|max:500',

        ];
    }

    public function messages()
    {
        return [
            'text.required'    => 'حقل النص (العربي) مطلوب.',
            'text.string'      => 'حقل النص (العربي) لازم يكون نص فقط.',
            'text.max'         => 'حقل النص (العربي) لا يجب أن يزيد عن 500 حرف.',

            'text_en.string'   => 'حقل النص (الإنجليزي) لازم يكون نص فقط.',
            'text_en.max'      => 'حقل النص (الإنجليزي) لا يجب أن يزيد عن 500 حرف.',
        ];
    }
}
