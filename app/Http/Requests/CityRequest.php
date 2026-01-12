<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CityRequest extends FormRequest
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
        $cityId = $this->route('city')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:91',
                'regex:/^[\p{Arabic}\s\-]+$/u', 
                Rule::unique('cities', 'name')
                    ->where('governorate_id', $this->governorate_id)
                    ->ignore($cityId)
            ],
            'name_en' => [
                'nullable',
                'string',
                'max:91',
                'regex:/^[a-zA-Z\s\-]+$/', 
                Rule::unique('cities', 'name_en')
                    ->where('governorate_id', $this->governorate_id)
                    ->ignore($cityId)
            ],
            'governorate_id' => [
                'required',
                'integer',
                'exists:governorates,id'
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
            'name.required' => 'الاسم مطلوب',
            'name.string' => 'الاسم يجب ان يكون نص',
            'name.max' => 'الاسم يجب ان يكون اقل من 91 حرف',
            'name.regex' => 'الاسم يجب ان يحتوي على حروف عربية فقط',
            'name.unique' => 'اسم المدينة موجود مسبقاً في هذه المحافظة',

            'name_en.string' => 'الاسم بالانجليزية يجب ان يكون نص',
            'name_en.max' => 'الاسم بالانجليزية يجب ان يكون اقل من 91 حرف',
            'name_en.regex' => 'الاسم بالانجليزية يجب ان يحتوي على حروف إنجليزية فقط',
            'name_en.unique' => 'اسم المدينة بالانجليزية موجود مسبقاً في هذه المحافظة',

            'governorate_id.required' => 'المحافظة مطلوبة',
            'governorate_id.integer' => 'المحافظة غير صحيحة',
            'governorate_id.exists' => 'المحافظة غير موجودة أو غير نشطة',
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
            'name' => 'اسم المدينة',
            'name_en' => 'اسم المدينة بالانجليزية',
            'governorate_id' => 'المحافظة',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->name ? strip_tags(trim($this->name)) : null,
            'name_en' => $this->name_en ? strip_tags(trim($this->name_en)) : null,
            'governorate_id' => $this->governorate_id ? (int) $this->governorate_id : null,
        ]);
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        $this->merge([
            'name' => htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8'),
            'name_en' => $this->name_en ? htmlspecialchars($this->name_en, ENT_QUOTES, 'UTF-8') : null,
        ]);
    }
}
