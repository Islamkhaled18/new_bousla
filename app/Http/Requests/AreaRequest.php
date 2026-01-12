<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AreaRequest extends FormRequest
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
        $areaId = $this->route('area')?->id;

        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:91',
                'regex:/^[\p{Arabic}\s\-]+$/u', // حروف عربية فقط
                Rule::unique('areas', 'name')
                    ->where('city_id', $this->city_id)
                    ->ignore($areaId)
            ],
            'name_en' => [
                'nullable',
                'string',
                'min:2',
                'max:91',
                'regex:/^[a-zA-Z\s\-]+$/', // حروف إنجليزية فقط
                Rule::unique('areas', 'name_en')
                    ->where('city_id', $this->city_id)
                    ->ignore($areaId)
            ],
            'city_id' => [
                'required',
                'integer',
                'exists:cities,id',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // name
            'name.required' => 'اسم المنطقة مطلوب',
            'name.string' => 'اسم المنطقة يجب أن يكون نصاً',
            'name.min' => 'اسم المنطقة يجب أن يكون على الأقل حرفين',
            'name.max' => 'اسم المنطقة يجب ألا يزيد عن 91 حرف',
            'name.regex' => 'اسم المنطقة يجب أن يحتوي على حروف عربية فقط',
            'name.unique' => 'اسم المنطقة موجود مسبقاً في هذه المدينة',

            // name_en
            'name_en.string' => 'اسم المنطقة بالإنجليزية يجب أن يكون نصاً',
            'name_en.min' => 'اسم المنطقة بالإنجليزية يجب أن يكون على الأقل حرفين',
            'name_en.max' => 'اسم المنطقة بالإنجليزية يجب ألا يزيد عن 91 حرف',
            'name_en.regex' => 'اسم المنطقة بالإنجليزية يجب أن يحتوي على حروف إنجليزية فقط',
            'name_en.unique' => 'اسم المنطقة بالإنجليزية موجود مسبقاً في هذه المدينة',

            // city_id
            'city_id.required' => 'المدينة مطلوبة',
            'city_id.integer' => 'المدينة غير صحيحة',
            'city_id.exists' => 'المدينة غير موجودة أو غير نشطة',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'اسم المنطقة',
            'name_en' => 'اسم المنطقة بالإنجليزية',
            'city_id' => 'المدينة',
        ];
    }

    /**
     * Prepare the data for validation.
     */
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

        if ($this->has('city_id')) {
            $this->merge([
                'city_id' => $this->city_id ? (int) $this->city_id : null,
            ]);
        }
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        if ($this->has('name')) {
            $this->merge([
                'name' => htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8'),
            ]);
        }

        if ($this->has('name_en') && $this->name_en) {
            $this->merge([
                'name_en' => htmlspecialchars($this->name_en, ENT_QUOTES, 'UTF-8'),
            ]);
        }
    }
}
