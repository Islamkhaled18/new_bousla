<?php

namespace Modules\Clients\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClientProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'in:male,female'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => [
                'nullable',
                'regex:/^01[0-9]{9}$/'
            ],
            'id_number' => [
                'nullable',
                'string',
                'max:14',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'date_of_birth' => ['nullable', 'date'],
            'blood_type' => ['nullable', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'personal_image' => 'image|mimes:jpeg,png,jpg|max:5120',
        ];

        // Password validation - only required if user wants to change it
        if ($this->filled('password')) {
            $rules['current_password'] = [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user()->password)) {
                        $fail('كلمة المرور القديمة غير صحيحة');
                    }
                }
            ];
            $rules['password'] = ['string', 'confirmed', 'min:8'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'first_name.string' => 'الاسم الأول يجب أن يكون نصًا',
            'first_name.max'    => 'الاسم الأول يجب ألا يزيد عن 255 حرف',

            'last_name.string' => 'اسم العائلة يجب أن يكون نصًا',
            'last_name.max'    => 'اسم العائلة يجب ألا يزيد عن 255 حرف',

            'gender.in' => 'الجنس يجب أن يكون ذكر أو أنثى',

            'email.email'  => 'صيغة البريد الإلكتروني غير صحيحة',
            'email.max'    => 'البريد الإلكتروني طويل جدًا',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',

            'phone.regex' => 'رقم الهاتف يجب أن يبدأ بـ 01 ويتكون من 11 رقم',

            'id_number.string' => 'الرقم القومي يجب أن يكون نصًا',
            'id_number.max'    => 'الرقم القومي يجب أن يتكون من 14 رقم',
            'id_number.unique' => 'الرقم القومي مستخدم بالفعل',

            'date_of_birth.date' => 'تاريخ الميلاد غير صالح',

            'blood_type.in' => 'فصيلة الدم غير صحيحة',

            'personal_image.image' => 'الصورة الشخصية غير صالحة',
            'personal_image.mimes' => 'صيغة الصورة غير مدعومة',
            'personal_image.max'   => 'حجم الصورة كبير جدًا',

            // Password
            'current_password.required' => 'كلمة المرور القديمة مطلوبة',
            'password.required' => 'كلمة المرور الجديدة مطلوبة',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 8 أحرف',
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'الاسم الأول',
            'last_name' => 'اسم العائلة',
            'gender' => 'الجنس',
            'email' => 'البريد الإلكتروني',
            'phone' => 'رقم الهاتف',
            'id_number' => 'الرقم القومي',
            'date_of_birth' => 'تاريخ الميلاد',
            'blood_type' => 'فصيلة الدم',
            'personal_image' => 'الصورة الشخصية',
            'current_password' => 'كلمة المرور القديمة',
            'password' => 'كلمة المرور الجديدة',
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
