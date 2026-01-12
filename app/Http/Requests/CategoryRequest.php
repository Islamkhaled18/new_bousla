<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;
        $isCreating = $this->isMethod('post');

        return [
            'name' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'min:2',
                'max:91',
                Rule::unique('categories', 'name')
                    ->where('main_category_id', $this->main_category_id)
                    ->ignore($categoryId)
            ],
            'name_en' => [
                'nullable',
                'string',
                'min:2',
                'max:91',
                Rule::unique('categories', 'name_en')
                    ->where('main_category_id', $this->main_category_id)
                    ->ignore($categoryId)
            ],
            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
                'different:' . $categoryId
            ],
            'image' => [
                $isCreating ? 'required' : 'nullable',
                'image',
                'mimes:png,jpg,jpeg,webp',
                'max:5120',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ],
            'main_category_id' => [
                'required',
                'integer',
                'exists:main_categories,id'
            ],
            'type' => [
                'nullable',
                'integer',
                'in:1,2'
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->type == 2 && empty($this->parent_id)) {
                $validator->errors()->add('parent_id', 'يجب اختيار القسم التابع عند اختيار قسم فرعي');
            }

            if ($this->parent_id && $this->main_category_id) {
                $parentCategory = \App\Models\Category::find($this->parent_id);
                if ($parentCategory && $parentCategory->main_category_id != $this->main_category_id) {
                    $validator->errors()->add('parent_id', 'القسم الأب يجب أن ينتمي لنفس التصنيف الرئيسي');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم القسم مطلوب',
            'name.unique' => 'اسم القسم موجود مسبقاً',
            'name_en.unique' => 'اسم القسم بالإنجليزية موجود مسبقاً',
            'parent_id.exists' => 'القسم التابع غير موجود',
            'parent_id.different' => 'لا يمكن اختيار القسم نفسه كقسم أب',
            'image.required' => 'الصورة مطلوبة',
            'image.mimes' => 'الصورة يجب أن تكون: png, jpg, jpeg, webp',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 5 ميجابايت',
            'main_category_id.required' => 'التصنيف الرئيسي مطلوب',
            'main_category_id.exists' => 'التصنيف الرئيسي غير موجود',
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
        if ($this->has('parent_id')) {
            $this->merge(['parent_id' => $this->parent_id ? (int) $this->parent_id : null]);
        }
        if ($this->has('main_category_id')) {
            $this->merge(['main_category_id' => (int) $this->main_category_id]);
        }
    }
}