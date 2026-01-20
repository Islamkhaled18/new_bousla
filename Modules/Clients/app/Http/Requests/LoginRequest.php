<?php

namespace Modules\Clients\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */

    public function rules(): array
    {
        return [
            'login'    => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'login.required'    => 'رقم الهاتف أو البريد الإلكتروني مطلوب',
            'password.required' => 'كلمة المرور مطلوبة',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $login = $this->input('login');

            // Check if it's email or phone
            $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

            // Check if user exists
            $userExists = \App\Models\User::where($fieldType, $login)->exists();

            if (!$userExists) {
                $validator->errors()->add('login', 'رقم الهاتف أو البريد الإلكتروني غير مسجل');
            }
        });
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
