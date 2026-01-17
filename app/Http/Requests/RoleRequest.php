<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roleId = $this->route('role');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($roleId),
            ],
            'permission' => 'required|array',
            'permission.*' => 'exists:permissions,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الدور مطلوب',
            'name.unique' => 'اسم الدور موجود بالفعل',
            'permission.required' => 'يجب اختيار صلاحية واحدة على الأقل',
            'permission.array' => 'صيغة الصلاحيات غير صحيحة',
            'permission.*.exists' => 'الصلاحية المحددة غير موجودة',
        ];
    }
}
