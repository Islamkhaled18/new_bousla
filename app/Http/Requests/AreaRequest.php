<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:91',
            'name_en' => 'nullable|string|max:91',
            'city_id' => 'required|exists:cities,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required'    => 'هذا الحقل مطلوب',
            'name.string'      => 'هذا الحقل يجب ان يكون نص',
            'name.max'         => 'هذا الحقل يجب ان يكون اقل من 91 حرف',
            'name_en.string'   => 'هذا الحقل يجب ان يكون نص',
            'name_en.max'      => 'هذا الحقل يجب ان يكون اقل من 91 حرف',
            'city_id.required' => 'هذا الحقل مطلوب',
            'city_id.exists'   => 'هذا الحقل غير موجود',
        ];
    }
}
