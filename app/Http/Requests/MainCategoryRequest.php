<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name'    => [$this->isMethod('post') ? 'required' : 'nullable', 'string', 'max:91'],
            'name_en' => ['nullable', 'string', 'max:91'],
            'image'   => 'mimes:png,jpg,bmp,jpeg,webp,svg|max:5120', //5MB
        ];
    }

    public function messages(): array
    {
        return [
            // name
            'name.required'    => 'الاسم (بالعربي) مطلوب.',
            'name.string'      => 'الاسم (بالعربي) يجب أن يكون نصاً.',
            'name.max'         => 'الاسم (بالعربي) لا يجب أن يزيد عن 91 حرف.',

            // name_en
            'name_en.string'   => 'الاسم (بالإنجليزي) يجب أن يكون نصاً.',
            'name_en.max'      => 'الاسم (بالإنجليزي) لا يجب أن يزيد عن 91 حرف.',

            // image
            'image.mimes'      => 'الصورة يجب أن تكون بامتداد: png, jpg, bmp, jpeg, webp, svg.',
            'image.max'        => 'حجم الصورة يجب ألا يتجاوز 5 ميجابايت.',
        ];
    }
}
