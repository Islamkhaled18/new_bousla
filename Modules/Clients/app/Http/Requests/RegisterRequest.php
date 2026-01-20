<?php

namespace Modules\Clients\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'password.min'        => 'كلمة المرور يجب ألا تقل عن 8 حروف',
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
