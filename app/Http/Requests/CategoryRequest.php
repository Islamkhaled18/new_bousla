<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name'             => [$this->isMethod('post') ? 'required' : 'nullable', 'string', 'max:91'],
            'name_en'          => ['nullable', 'string', 'max:91'],
            'parent_id'        => 'nullable|exists:categories,id',
            'image'            => 'mimes:png,jpg,bmp,jpeg,webp,svg|max:5120', //5MB
            'main_category_id' => 'nullable|exists:main_categories,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if ($this->type == 2 && empty($this->parent_id)) {
                $validator->errors()->add('parent_id', 'يجب اختيار القسم التابع');
            }
        });
    }

    public function messages(): array
    {
        return [
            // name
            'name.required'           => 'اسم القسم (بالعربي) مطلوب.',
            'name.string'             => 'اسم القسم (بالعربي) يجب أن يكون نصاً.',
            'name.max'                => 'اسم القسم (بالعربي) لا يجب أن يزيد عن 91 حرف.',

            // name_en
            'name_en.string'          => 'اسم القسم (بالإنجليزي) يجب أن يكون نصاً.',
            'name_en.max'             => 'اسم القسم (بالإنجليزي) لا يجب أن يزيد عن 91 حرف.',

            // parent_id
            'parent_id.exists'        => 'القسم التابع غير صحيح.',

            // image
            'image.mimes'             => 'الصورة يجب أن تكون بامتداد: png, jpg, bmp, jpeg, webp, svg.',
            'image.max'               => 'حجم الصورة يجب ألا يتجاوز 3 ميجابايت.',

            // main_category_id
            'main_category_id.exists' => 'القسم الرئيسي المختار غير صحيح.',
        ];
    }
}
