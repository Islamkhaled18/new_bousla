<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class ProfileRequest extends FormRequest
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
        $adminId = $this->route('admin')?->id;

        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => [
                'required',
                'regex:/^01[0-9]{9}$/'
            ],
        ];

        if ($this->isMethod('POST')) {
            $rules['password'] = ['required', 'confirmed', 'min:8'];
        } else {
            if ($this->filled('password')) {
                $rules['current_password'] = [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!Hash::check($value, $this->user()->password)) {
                            $fail('كلمة المرور القديمة غير صحيحة');
                        }
                    }
                ];
                $rules['password'] = ['required', 'confirmed', 'min:8'];
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.string' => 'الاسم يجب أن يكون نص',
            'name.max' => 'الاسم يجب ألا يزيد عن 255 حرف',

            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'البريد الإلكتروني مستخدم من قبل',
            'email.max' => 'البريد الإلكتروني يجب ألا يزيد عن 255 حرف',

            'current_password.required' => 'كلمة المرور القديمة مطلوبة لتغيير كلمة المرور',

            'password.required' => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.regex' => 'رقم الهاتف يجب أن يكون 11 رقم ويبدأ بـ 01'
        ];
    }
}
