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

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم الوظيفة',
            'name.string'   => 'يجب ادخال نص في اسم الوظيفة',
            'name.max'      => 'يجب الا يزيد اسم الوظيفة عن 91 حرف',
            'name.unique'   => 'اسم الوظيفة موجود مسبقاً',


            'name_en.string'   => 'يجب ادخال نص في اسم الوظيفة بالانجليزية',
            'name_en.max'      => 'يجب الا يزيد اسم الوظيفة بالانجليزية عن 91 حرف',
            'name_en.unique'   => 'اسم الوظيفة بالانجليزية موجود مسبقاً',
        ];
    }
}
