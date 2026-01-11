<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TermConditionRequest extends FormRequest
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
            'name'    => 'required|string|max:1000',
            'name_en' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'name.required'    => 'الاسم مطلوب',
            'name.string'      => 'لابد ان يكون حقل نصي',
            'name.max'         => 'لابد ان يكون اقل من 1000 حرف',
            'name_en.string'   => 'لابد ان يكون حقل نصي',
            'name_en.max'      => 'لابد ان يكون اقل من 1000 حرف',
        ];
    }
}
