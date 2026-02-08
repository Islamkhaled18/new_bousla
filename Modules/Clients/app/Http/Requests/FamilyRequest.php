<?php

namespace Modules\Clients\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'relationship' => 'required|in:father,mother,sister,brother',
            'age' => 'required|numeric|min:1|max:100',
            'gender' => 'required|in:male,female',
            'phone' => [
                'required',
                'regex:/^01[0-9]{9}$/',
                'unique:families,phone'
            ],
            'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.string'   => 'الاسم لازم يكون نص',
            'name.min'      => 'الاسم لازم يكون 3 حروف على الأقل',
            'name.max'      => 'الاسم لا يزيد عن 255 حرف',

            'relationship.required' => 'صلة القرابة مطلوبة',
            'relationship.in'       => 'صلة القرابة غير صحيحة',

            'age.required' => 'السن مطلوب',
            'age.numeric'  => 'السن لازم يكون رقم',
            'age.min'      => 'السن لازم يكون أكبر من سنة',
            'age.max'      => 'السن لا يزيد عن 100 سنة',

            'gender.required' => 'النوع مطلوب',
            'gender.in'       => 'النوع لازم يكون ذكر أو أنثى',

            'phone.required' => 'رقم الموبايل مطلوب',
            'phone.regex'    => 'رقم الموبايل غير صحيح (يجب أن يبدأ بـ 01 ويتكون من 11 رقم)',
            'phone.unique'   => 'رقم الموبايل مسجل لدينا بالفعل',

            'blood_type.in' => 'فصيلة الدم غير صحيحة',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
