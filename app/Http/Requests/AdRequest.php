<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adId = $this->route('ad')?->id;
        $isCreating = $this->isMethod('post');

        return [
            'name' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'min:3',
                'max:191',
                Rule::unique('ads', 'name')->ignore($adId)
            ],
            'name_en' => [
                'nullable',
                'string',
                'min:3',
                'max:191',
                Rule::unique('ads', 'name_en')->ignore($adId)
            ],
            'image' => [
                $isCreating ? 'required' : 'nullable',
                'image',
                'mimes:png,jpg,jpeg,webp',
                'max:5120',
                'dimensions:min_width=300,min_height=200,max_width=3000,max_height=3000'
            ],
            'start_date' => [
                $isCreating ? 'required' : 'sometimes',
                'date',
                'date_format:Y-m-d',
                $isCreating ? 'after_or_equal:today' : 'date'
            ],
            'end_date' => [
                $isCreating ? 'required' : 'sometimes',
                'date',
                'date_format:Y-m-d',
                'after:start_date'
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
        
            if ($this->hasFile('image')) {
                $file = $this->file('image');
                $mimeType = $file->getMimeType();
                
                $allowedMimes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
                
                if (!in_array($mimeType, $allowedMimes)) {
                    $validator->errors()->add('image', 'نوع الملف غير مسموح به');
                }
                
                try {
                    $imageInfo = @getimagesize($file->getRealPath());
                    if ($imageInfo === false) {
                        $validator->errors()->add('image', 'الملف ليس صورة صالحة');
                    }
                } catch (\Exception $e) {
                    $validator->errors()->add('image', 'فشل التحقق من الصورة');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            // name
            'name.required' => 'اسم الإعلان (بالعربي) مطلوب',
            'name.string' => 'اسم الإعلان (بالعربي) يجب أن يكون نصاً',
            'name.min' => 'اسم الإعلان يجب أن يكون 3 أحرف على الأقل',
            'name.max' => 'اسم الإعلان (بالعربي) لا يجب أن يزيد عن 191 حرف',
            'name.unique' => 'اسم الإعلان موجود مسبقاً',

            // name_en
            'name_en.string' => 'اسم الإعلان (بالإنجليزي) يجب أن يكون نصاً',
            'name_en.min' => 'اسم الإعلان بالإنجليزية يجب أن يكون 3 أحرف على الأقل',
            'name_en.max' => 'اسم الإعلان (بالإنجليزي) لا يجب أن يزيد عن 191 حرف',
            'name_en.unique' => 'اسم الإعلان بالإنجليزية موجود مسبقاً',

            // image
            'image.required' => 'صورة الإعلان مطلوبة',
            'image.image' => 'يجب أن يكون الملف صورة',
            'image.mimes' => 'الصورة يجب أن تكون بامتداد: png, jpg, jpeg, webp',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 5 ميجابايت',
            'image.dimensions' => 'أبعاد الصورة غير مناسبة',

            // start_date
            'start_date.required' => 'تاريخ البدء مطلوب',
            'start_date.date' => 'تاريخ البدء يجب أن يكون تاريخاً صالحاً',
            'start_date.date_format' => 'تنسيق تاريخ البدء غير صحيح',
            'start_date.after_or_equal' => 'تاريخ البدء يجب أن يكون اليوم أو في المستقبل',

            // end_date
            'end_date.required' => 'تاريخ الانتهاء مطلوب',
            'end_date.date' => 'تاريخ الانتهاء يجب أن يكون تاريخاً صالحاً',
            'end_date.date_format' => 'تنسيق تاريخ الانتهاء غير صحيح',
            'end_date.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البدء',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('name')) {
            $this->merge(['name' => strip_tags(trim($this->name))]);
        }
        
        if ($this->has('name_en')) {
            $this->merge(['name_en' => $this->name_en ? strip_tags(trim($this->name_en)) : null]);
        }
    }

    protected function passedValidation(): void
    {
        if ($this->has('name')) {
            $this->merge(['name' => htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8')]);
        }
        
        if ($this->has('name_en') && $this->name_en) {
            $this->merge(['name_en' => htmlspecialchars($this->name_en, ENT_QUOTES, 'UTF-8')]);
        }
    }
}