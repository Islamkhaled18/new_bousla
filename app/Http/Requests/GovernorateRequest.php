<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GovernorateRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:91',
            'name_en' => 'nullable|string|max:91',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال اسم المحافظة',
            'name.string'   => 'يجب ادخال نص في اسم المحافظة',
            'name.max'      => 'يجب الا يزيد اسم المحافظة عن 91 حرف',

            'name_en.string'   => 'يجب ادخال نص في اسم المحافظة بالانجليزية',
            'name_en.max'      => 'يجب الا يزيد اسم المحافظة بالانجليزية عن 91 حرف',
        ];
    }
}
