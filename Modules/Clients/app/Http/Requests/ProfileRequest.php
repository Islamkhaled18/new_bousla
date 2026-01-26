<?php

namespace Modules\Clients\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $isCreating = $this->isMethod('post');
        $rules = [
            'first_name' => [$isCreating ? 'required' : 'sometimes', 'string', 'max:255'],
            'last_name' => [$isCreating ? 'required' : 'sometimes', 'string', 'max:255'],
            'gender' => ['in:male,female'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => [
                $isCreating ? 'required' : 'sometimes',
                'regex:/^01[0-9]{9}$/'
            ],
            'id_number' => [
                'nullable',
                'string',
                'max:14',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'personal_image' => 'image|mimes:jpeg,png,jpg|max:5120',
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
            // الاسم الأول
            'first_name.required' => 'الاسم الأول مطلوب.',
            'first_name.string'   => 'الاسم الأول يجب أن يكون نصاً.',
            'first_name.max'      => 'الاسم الأول يجب ألا يتجاوز 255 حرفاً.',

            // اسم العائلة
            'last_name.required'  => 'اسم العائلة مطلوب.',
            'last_name.string'    => 'اسم العائلة يجب أن يكون نصاً.',
            'last_name.max'       => 'اسم العائلة يجب ألا يتجاوز 255 حرفاً.',

            // النوع
            'gender.in'           => 'النوع المختار غير صحيح، يجب أن يكون ذكر أو أنثى.',

            // البريد الإلكتروني
            'email.email'         => 'يجب إدخال بريد إلكتروني صحيح.',
            'email.max'           => 'البريد الإلكتروني طويل جداً.',
            'email.unique'        => 'هذا البريد الإلكتروني مسجل لدينا بالفعل.',

            // رقم الهاتف
            'phone.required'      => 'رقم الهاتف مطلوب.',
            'phone.regex'         => 'رقم الهاتف يجب أن يكون رقم مصري صحيح (01xxxxxxxx).',

            // الرقم القومي
            'id_number.max'       => 'الرقم القومي يجب ألا يتجاوز 14 خانة.',
            'id_number.unique'    => 'الرقم القومي مسجل لدينا بالفعل.',

            // الصورة الشخصية
            'personal_image.image' => 'الملف المرفوع يجب أن يكون صورة.',
            'personal_image.mimes' => 'يجب أن يكون امتداد الصورة: jpeg, png, jpg.',
            'personal_image.max'   => 'حجم الصورة لا يجب أن يتخطى 5 ميجابايت.',

            // كلمة المرور
            'password.required'   => 'كلمة المرور مطلوبة.',
            'password.confirmed'  => 'تأكيد كلمة المرور غير متطابق.',
            'password.min'        => 'كلمة المرور يجب ألا تقل عن 8 رموز.',

            // كلمة المرور الحالية (تظهر عند التعديل فقط)
            'current_password.required' => 'يجب إدخال كلمة المرور الحالية لتغيير كلمة المرور.',
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
