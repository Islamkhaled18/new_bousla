<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutUsRequest extends FormRequest
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
            'text' => [
                'required',
                'string',
                'min:2',
                'max:500',
            ],
            'text_en' => [
                'nullable',
                'string',
                'min:2',
                'max:500',
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->has('text') && $this->containsMaliciousContent($this->text)) {
                $validator->errors()->add('text', 'النص يحتوي على محتوى غير مسموح به');
            }

            if ($this->has('text_en') && $this->text_en && $this->containsMaliciousContent($this->text_en)) {
                $validator->errors()->add('text_en', 'النص بالإنجليزية يحتوي على محتوى غير مسموح به');
            }
        });
    }

    private function containsMaliciousContent(string $content): bool
    {
        $maliciousPatterns = [
            '/<script[\s\S]*?<\/script>/i',
            '/javascript:/i',
            '/on\w+\s*=/i', // onclick, onload, etc.
            '/<iframe/i',
            '/<object/i',
            '/<embed/i',
            '/eval\(/i',
        ];

        foreach ($maliciousPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
    }

    public function messages(): array
    {
        return [
            'text.required' => 'النص مطلوب',
            'text.string' => 'النص يجب أن يكون نصاً',
            'text.min' => 'النص يجب أن يكون حرفين على الأقل',
            'text.max' => 'النص يجب ألا يزيد عن 500 حرف',

            'text_en.string' => 'النص بالإنجليزية يجب أن يكون نصاً',
            'text_en.min' => 'النص بالإنجليزية يجب أن يكون حرفين على الأقل',
            'text_en.max' => 'النص بالإنجليزية يجب ألا يزيد عن 500 حرف',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('text')) {
            $this->merge(['text' => strip_tags(trim($this->text))]);
        }

        if ($this->has('text_en')) {
            $this->merge(['text_en' => $this->text_en ? strip_tags(trim($this->text_en)) : null]);
        }
    }

    protected function passedValidation(): void
    {
        if ($this->has('text')) {
            $this->merge(['text' => htmlspecialchars($this->text, ENT_QUOTES, 'UTF-8')]);
        }

        if ($this->has('text_en') && $this->text_en) {
            $this->merge(['text_en' => htmlspecialchars($this->text_en, ENT_QUOTES, 'UTF-8')]);
        }
    }
}
