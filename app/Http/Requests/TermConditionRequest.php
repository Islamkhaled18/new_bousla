<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $termConditionId = $this->route('term')?->id;

        return [
            'name' => [
                'required',
                'string',
                'min:10',
                'max:10000',
                Rule::unique('terms_conditions', 'name')->ignore($termConditionId)
            ],
            'name_en' => [
                'nullable',
                'string',
                'min:10',
                'max:10000',
                Rule::unique('terms_conditions', 'name_en')->ignore($termConditionId)
            ],
            'role' => [
                'required',
                Rule::in(['general', 'client', 'doctor']),
            ],
            'version' => [
                'required',
                'string',
                'max:20',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الشروط والأحكام مطلوبة',
            'name.min' => 'يجب أن يكون النص على الأقل 10 أحرف',
            'name.max' => 'يجب ألا يزيد النص عن 10000 حرف',
            'name.unique' => 'هذا النص موجود مسبقاً',

            'name_en.min' => 'يجب أن يكون النص بالإنجليزية على الأقل 10 أحرف',
            'name_en.max' => 'يجب ألا يزيد النص بالإنجليزية عن 10000 حرف',
            'name_en.unique' => 'هذا النص بالإنجليزية موجود مسبقاً',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('name')) {
            $this->merge([
                'name' => strip_tags(trim($this->name)),
            ]);
        }

        if ($this->has('name_en')) {
            $this->merge([
                'name_en' => $this->name_en ? strip_tags(trim($this->name_en)) : null,
            ]);
        }
    }
}
