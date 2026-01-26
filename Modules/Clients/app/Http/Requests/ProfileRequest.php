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
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['in:male,female'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => [
                'required',
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


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
