<?php

namespace Modules\Clients\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Clients\app\Rules\ValidTermsCondition;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'phone'      => 'required|string|max:20|unique:users,phone',
            'password'   => 'required|string|min:8|confirmed',
            'is_accept_terms' => 'required|in:1',
            'terms_condition_uuid' => ['required', 'exists:terms_conditions,uuid', new ValidTermsCondition('patient')],


        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'الاسم الأول مطلوب',
            'last_name.required'  => 'اسم العائلة مطلوب',
            'phone.required'      => 'رقم الهاتف مطلوب',
            'phone.unique'        => 'رقم الهاتف مستخدم بالفعل',
            'password.required'   => 'كلمة المرور مطلوبة',
            'password.confirmed'  => 'تأكيد كلمة المرور غير متطابق',
            'is_accept_terms.required' => 'يجب الموافقة على الشروط والأحكام',
            'is_accept_terms.in' => 'يجب الموافقة على الشروط والأحكام',
            'terms_condition_uuid.required' => 'معرف الشروط والأحكام مطلوب',
            'terms_condition_uuid.exists' => 'الشروط والأحكام غير موجودة',
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
