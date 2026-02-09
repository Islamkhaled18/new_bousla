<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobTitleRequest extends FormRequest
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
        $jobTitleId = $this->route('job_title') ? $this->route('job_title')->id : null;

        return [
            'name' => [
                'required',
                'string',
                'max:91',
                'unique:job_titles,name,' . $jobTitleId
            ],
            'name_en' => [
                'nullable',
                'string',
                'max:91',
                'unique:job_titles,name_en,' . $jobTitleId
            ],
            'icon' => [
                'required',
                'string',
                'max:255'
            ],
            'icon_color' => [
                'required',
                'string',
                'max:255'
            ],
            'bg_color' => [
                'required',
                'string',
                'max:255'
            ]
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'name' => strip_tags($this->name),
            'name_en' => strip_tags($this->name_en),
        ]);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم المسمى الوظيفي مطلوب',
            'name.string'   => 'اسم المسمى الوظيفي يجب أن يكون نصًا',
            'name.max'      => 'اسم المسمى الوظيفي يجب ألا يزيد عن 91 حرف',
            'name.unique'   => 'اسم المسمى الوظيفي مستخدم بالفعل',

            'name_en.string' => 'الاسم الإنجليزي يجب أن يكون نصًا',
            'name_en.max'    => 'الاسم الإنجليزي يجب ألا يزيد عن 91 حرف',
            'name_en.unique' => 'الاسم الإنجليزي مستخدم بالفعل',

            'icon.required' => 'الأيقونة مطلوبة',
            'icon.string'   => 'الأيقونة يجب أن تكون نصًا',
            'icon.max'      => 'قيمة الأيقونة طويلة جدًا',

            'icon_color.required' => 'لون الأيقونة مطلوب',
            'icon_color.string'   => 'لون الأيقونة يجب أن يكون نصًا',
            'icon_color.max'      => 'قيمة لون الأيقونة طويلة جدًا',

            'bg_color.required' => 'لون الخلفية مطلوب',
            'bg_color.string'   => 'لون الخلفية يجب أن يكون نصًا',
            'bg_color.max'      => 'قيمة لون الخلفية طويلة جدًا',
        ];
    }
}
