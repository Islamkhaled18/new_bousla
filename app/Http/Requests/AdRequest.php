<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
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
            'name'     => [$this->isMethod('post') ? 'required' : 'nullable', 'string', 'max:91'],
            'name_en'  => ['nullable', 'string', 'max:91'],
            'image'    => 'mimes:png,jpg,bmp,jpeg,webp,svg|max:5120', //5MB
            'start_date' => [$this->isMethod('post') ? 'required' : 'nullable', 'date'],
            'end_date'   => [$this->isMethod('post') ? 'required' : 'nullable', 'date', 'after_or_equal:start_date'],

        ];
    }

    public function messages(): array
    {
        return [
            // name
            'name.required'    => 'اسم المنتج (بالعربي) مطلوب.',
            'name.string'      => 'اسم المنتج (بالعربي) يجب أن يكون نصاً.',
            'name.max'         => 'اسم المنتج (بالعربي) لا يجب أن يزيد عن 91 حرف.',

            // name_en
            'name_en.string'   => 'اسم المنتج (بالإنجليزي) يجب أن يكون نصاً.',
            'name_en.max'      => 'اسم المنتج (بالإنجليزي) لا يجب أن يزيد عن 91 حرف.',

            // image
            'image.mimes'      => 'الصورة يجب أن تكون بامتداد: png, jpg, bmp, jpeg, webp, svg.',
            'image.max'        => 'حجم الصورة يجب ألا يتجاوز 5 ميجابايت.',

            // start_date
            'start_date.required' => 'تاريخ البدء مطلوب.',
            'start_date.date'     => 'تاريخ البدء يجب أن يكون تاريخاً صالحاً.',
            // end_date
            'end_date.required'   => 'تاريخ الانتهاء مطلوب.',
            'end_date.date'       => 'تاريخ الانتهاء يجب أن يكون تاريخاً صالحاً.',
            'end_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون بعد أو يساوي تاريخ البدء.',

        ];
    }
}
