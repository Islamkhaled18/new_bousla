<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MainCategoryRequest extends FormRequest
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
        $mainCategoryId = $this->route('main_category')?->id;
        $isCreating = $this->isMethod('post');
        
        return [
            'name' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'max:91',
                'min:2',
                'regex:/^[\p{Arabic}\s\-]+$/u',
                Rule::unique('main_categories', 'name')->ignore($mainCategoryId)
            ],
            'name_en' => [
                'nullable',
                'string',
                'max:91',
                'min:2',
                'regex:/^[a-zA-Z\s\-]+$/',
                Rule::unique('main_categories', 'name_en')->ignore($mainCategoryId)
            ],
            'image' => [
                $isCreating ? 'required' : 'nullable',
                'image',
                'mimes:png,jpg,jpeg,webp', 
                'max:5120',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
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
            'name.required' => 'الاسم (بالعربي) مطلوب',
            'name.string' => 'الاسم (بالعربي) يجب أن يكون نصاً',
            'name.max' => 'الاسم (بالعربي) لا يجب أن يزيد عن 91 حرف',
            'name.min' => 'الاسم (بالعربي) يجب أن يكون على الأقل حرفين',
            'name.regex' => 'الاسم (بالعربي) يجب أن يحتوي على حروف عربية فقط',
            'name.unique' => 'اسم التصنيف الرئيسي موجود مسبقاً',

            // name_en
            'name_en.string' => 'الاسم (بالإنجليزي) يجب أن يكون نصاً',
            'name_en.max' => 'الاسم (بالإنجليزي) لا يجب أن يزيد عن 91 حرف',
            'name_en.min' => 'الاسم (بالإنجليزي) يجب أن يكون على الأقل حرفين',
            'name_en.regex' => 'الاسم (بالإنجليزي) يجب أن يحتوي على حروف إنجليزية فقط',
            'name_en.unique' => 'اسم التصنيف الرئيسي بالإنجليزية موجود مسبقاً',

            // image
            'image.required' => 'الصورة مطلوبة',
            'image.image' => 'يجب أن يكون الملف صورة',
            'image.mimes' => 'الصورة يجب أن تكون بامتداد: png, jpg, jpeg, webp',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 5 ميجابايت',
            'image.dimensions' => 'أبعاد الصورة يجب أن تكون بين 100x100 و 2000x2000 بكسل',
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
            'name' => 'اسم التصنيف الرئيسي',
            'name_en' => 'اسم التصنيف الرئيسي بالإنجليزية',
            'image' => 'صورة التصنيف',
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

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->hasFile('image')) {
                $file = $this->file('image');
                $mimeType = $file->getMimeType();
                
                $allowedMimes = [
                    'image/png',
                    'image/jpeg',
                    'image/jpg',
                    'image/webp'
                ];
                
                if (!in_array($mimeType, $allowedMimes)) {
                    $validator->errors()->add('image', 'نوع الملف غير مسموح به');
                }
                
                try {
                    $imageInfo = @getimagesize($file->getRealPath());
                    if ($imageInfo === false) {
                        $validator->errors()->add('image', 'الملف ليس صورة صالحة');
                    }
                } catch (\Exception $e) {
                    $validator->errors()->add('image', 'فشل التحقق من الصورة');
                }
            }
        });
    }
}