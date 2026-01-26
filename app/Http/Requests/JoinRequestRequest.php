<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JoinRequestRequest extends FormRequest
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
        $joinRequestId = $this->route('join_request')?->id;
        $isCreating = $this->isMethod('post');
        $imageValidationRules = [
            $isCreating ? 'required' : 'nullable',
            'image',
            'mimes:png,jpg,jpeg,webp',
            'max:5120',
            // 'dimensions:min_width=300,min_height=200,max_width=3000,max_height=3000'
        ];

        return [
            'first_name' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'min:3',
                'max:191',
                Rule::unique('join_requests', 'first_name')->ignore($joinRequestId)
            ],
            'last_name' => [
                'nullable',
                'string',
                'min:3',
                'max:191',
                Rule::unique('join_requests', 'last_name')->ignore($joinRequestId)
            ],
            'phone' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'regex:/^01[0-9]{9}$/',
                Rule::unique('join_requests', 'phone')->ignore($joinRequestId)
            ],
            'address' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'min:3',
                'max:191',
            ],
            'email' => [
                $isCreating ? 'required' : 'sometimes',
                'email',
                'max:191',
                Rule::unique('join_requests', 'email')->ignore($joinRequestId)
            ],
            'gender' => [
                $isCreating ? 'required' : 'sometimes',
                'in:male,female',
            ],
            'about_me' => [
                'required',
                'string',
                'max:191',
            ],
            'id_number' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'regex:/^[0-9]{14}$/',
                Rule::unique('join_requests', 'id_number')->ignore($joinRequestId)
            ],
            'job_title_id' => [
                $isCreating ? 'required' : 'sometimes',
                'exists:job_titles,id'
            ],
            'area_id' => [
                $isCreating ? 'required' : 'sometimes',
                'exists:areas,id'
            ],
            'organization_name' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'min:3',
                'max:191',
            ],
            'organization_phone_first' => [
                $isCreating ? 'required' : 'sometimes',
                'regex:/^(01\d{0,9}|040\d{0,7})$/',
            ],

            'organization_phone_second' => [
                'nullable',
                'string',
                'regex:/^(01\d{0,9}|040\d{0,7})$/',
            ],
            'organization_phone_third' => [
                'nullable',
                'string',
                'regex:/^(01\d{0,9}|040\d{0,7})$/',
            ],
            'organization_location_url' => [
                $isCreating ? 'required' : 'sometimes',
                'url',
                'regex:/^https?:\/\/(www\.)?(google\.com\/maps|maps\.google\.com|(maps\.)?goo\.gl\/maps|maps\.app\.goo\.gl|g\.co\/maps)/',
                'max:191',
            ],
            'building_number' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'max:50',
            ],
            'floor_number' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'max:50',
            ],
            'apartment_number' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'max:50',
            ],
            'personal_image' => $imageValidationRules,
            'logo' => $imageValidationRules,
            'id_image_front' => $imageValidationRules,
            'id_image_back' => $imageValidationRules,
            'graduation_certificate' => $imageValidationRules,
            'professional_license' => $imageValidationRules,
            'syndicate_card' => $imageValidationRules,


            // Multiple images for organization
            'photo' => 'nullable|array',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            // First Name
            'first_name.required' => 'الاسم الأول مطلوب',
            'first_name.string' => 'الاسم الأول يجب أن يكون نصاً',
            'first_name.min' => 'الاسم الأول يجب أن يكون 3 أحرف على الأقل',
            'first_name.max' => 'الاسم الأول يجب ألا يتجاوز 191 حرفاً',
            'first_name.unique' => 'الاسم الأول مستخدم بالفعل',

            // Last Name
            'last_name.string' => 'اسم العائلة يجب أن يكون نصاً',
            'last_name.min' => 'اسم العائلة يجب أن يكون 3 أحرف على الأقل',
            'last_name.max' => 'اسم العائلة يجب ألا يتجاوز 191 حرفاً',
            'last_name.unique' => 'اسم العائلة مستخدم بالفعل',

            // Phone
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.string' => 'رقم الهاتف يجب أن يكون نصاً',
            'phone.regex' => 'رقم الهاتف يجب أن يكون بصيغة صحيحة (11 رقم يبدأ بـ 01)',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل',

            // Address
            'address.required' => 'العنوان مطلوب',
            'address.string' => 'العنوان يجب أن يكون نصاً',
            'address.min' => 'العنوان يجب أن يكون 3 أحرف على الأقل',
            'address.max' => 'العنوان يجب ألا يتجاوز 191 حرفاً',

            // Email
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني يجب أن يكون بصيغة صحيحة',
            'email.max' => 'البريد الإلكتروني يجب ألا يتجاوز 191 حرفاً',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',

            // About Me
            'about_me.required' => 'نبذة عني مطلوبة',
            'about_me.string' => 'نبذة عني يجب أن تكون نصاً',
            'about_me.max' => 'نبذة عني يجب ألا تتجاوز 191 حرفاً',

            // ID Number
            'id_number.required' => 'رقم الهوية مطلوب',
            'id_number.string' => 'رقم الهوية يجب أن يكون نصاً',
            'id_number.regex' => 'رقم الهوية يجب أن يكون 14 رقماً بالضبط',
            'id_number.unique' => 'رقم الهوية مستخدم بالفعل',

            // Job Title
            'job_title_id.required' => 'المسمى الوظيفي مطلوب',
            'job_title_id.exists' => 'المسمى الوظيفي المختار غير موجود',

            // Area
            'area_id.required' => 'المنطقة مطلوبة',
            'area_id.exists' => 'المنطقة المختارة غير موجودة',

            // Organization Name
            'organization_name.required' => 'اسم المنظمة مطلوب',
            'organization_name.string' => 'اسم المنظمة يجب أن يكون نصاً',
            'organization_name.min' => 'اسم المنظمة يجب أن يكون 3 أحرف على الأقل',
            'organization_name.max' => 'اسم المنظمة يجب ألا يتجاوز 191 حرفاً',

            // Organization Phone First
            'organization_phone_first.required' => 'رقم هاتف المنظمة الأول مطلوب',
            'organization_phone_first.regex' => 'رقم هاتف المنظمة الأول يجب أن يكون بصيغة صحيحة (يبدأ بـ 01 أو 040)',

            // Organization Phone Second
            'organization_phone_second.string' => 'رقم هاتف المنظمة الثاني يجب أن يكون نصاً',
            'organization_phone_second.regex' => 'رقم هاتف المنظمة الثاني يجب أن يكون بصيغة صحيحة (يبدأ بـ 01 أو 040)',

            // Organization Phone Third
            'organization_phone_third.string' => 'رقم هاتف المنظمة الثالث يجب أن يكون نصاً',
            'organization_phone_third.regex' => 'رقم هاتف المنظمة الثالث يجب أن يكون بصيغة صحيحة (يبدأ بـ 01 أو 040)',

            // Organization Location URL
            'organization_location_url.required' => 'رابط موقع المنظمة على الخريطة مطلوب',
            'organization_location_url.url' => 'رابط موقع المنظمة يجب أن يكون رابطاً صحيحاً',
            'organization_location_url.regex' => 'رابط موقع المنظمة يجب أن يكون من Google Maps',
            'organization_location_url.max' => 'رابط موقع المنظمة يجب ألا يتجاوز 191 حرفاً',

            // Building Number
            'building_number.required' => 'رقم المبنى مطلوب',
            'building_number.string' => 'رقم المبنى يجب أن يكون نصاً',
            'building_number.max' => 'رقم المبنى يجب ألا يتجاوز 50 حرفاً',

            // Floor Number
            'floor_number.required' => 'رقم الطابق مطلوب',
            'floor_number.string' => 'رقم الطابق يجب أن يكون نصاً',
            'floor_number.max' => 'رقم الطابق يجب ألا يتجاوز 50 حرفاً',

            // Apartment Number
            'apartment_number.required' => 'رقم الشقة مطلوب',
            'apartment_number.string' => 'رقم الشقة يجب أن يكون نصاً',
            'apartment_number.max' => 'رقم الشقة يجب ألا يتجاوز 50 حرفاً',

            // Personal Image
            'personal_image.required' => 'الصورة الشخصية مطلوبة',
            'personal_image.image' => 'الصورة الشخصية يجب أن تكون صورة',
            'personal_image.mimes' => 'الصورة الشخصية يجب أن تكون بصيغة: png, jpg, jpeg, webp',
            'personal_image.max' => 'حجم الصورة الشخصية يجب ألا يتجاوز 5 ميجابايت',
            'personal_image.dimensions' => 'أبعاد الصورة الشخصية يجب أن تكون بين 300x200 و 3000x3000 بكسل',

            // Logo
            'logo.required' => 'شعار المنظمة مطلوب',
            'logo.image' => 'شعار المنظمة يجب أن يكون صورة',
            'logo.mimes' => 'شعار المنظمة يجب أن يكون بصيغة: png, jpg, jpeg, webp',
            'logo.max' => 'حجم شعار المنظمة يجب ألا يتجاوز 5 ميجابايت',
            'logo.dimensions' => 'أبعاد شعار المنظمة يجب أن تكون بين 300x200 و 3000x3000 بكسل',

            // ID Image Front
            'id_image_front.required' => 'صورة الهوية (الوجه الأمامي) مطلوبة',
            'id_image_front.image' => 'صورة الهوية (الوجه الأمامي) يجب أن تكون صورة',
            'id_image_front.mimes' => 'صورة الهوية (الوجه الأمامي) يجب أن تكون بصيغة: png, jpg, jpeg, webp',
            'id_image_front.max' => 'حجم صورة الهوية (الوجه الأمامي) يجب ألا يتجاوز 5 ميجابايت',
            'id_image_front.dimensions' => 'أبعاد صورة الهوية (الوجه الأمامي) يجب أن تكون بين 300x200 و 3000x3000 بكسل',

            // ID Image Back
            'id_image_back.required' => 'صورة الهوية (الوجه الخلفي) مطلوبة',
            'id_image_back.image' => 'صورة الهوية (الوجه الخلفي) يجب أن تكون صورة',
            'id_image_back.mimes' => 'صورة الهوية (الوجه الخلفي) يجب أن تكون بصيغة: png, jpg, jpeg, webp',
            'id_image_back.max' => 'حجم صورة الهوية (الوجه الخلفي) يجب ألا يتجاوز 5 ميجابايت',
            'id_image_back.dimensions' => 'أبعاد صورة الهوية (الوجه الخلفي) يجب أن تكون بين 300x200 و 3000x3000 بكسل',

            // Graduation Certificate
            'graduation_certificate.required' => 'شهادة التخرج مطلوبة',
            'graduation_certificate.image' => 'شهادة التخرج يجب أن تكون صورة',
            'graduation_certificate.mimes' => 'شهادة التخرج يجب أن تكون بصيغة: png, jpg, jpeg, webp',
            'graduation_certificate.max' => 'حجم شهادة التخرج يجب ألا يتجاوز 5 ميجابايت',
            'graduation_certificate.dimensions' => 'أبعاد شهادة التخرج يجب أن تكون بين 300x200 و 3000x3000 بكسل',

            // Professional License
            'professional_license.required' => 'الترخيص المهني مطلوب',
            'professional_license.image' => 'الترخيص المهني يجب أن يكون صورة',
            'professional_license.mimes' => 'الترخيص المهني يجب أن يكون بصيغة: png, jpg, jpeg, webp',
            'professional_license.max' => 'حجم الترخيص المهني يجب ألا يتجاوز 5 ميجابايت',
            'professional_license.dimensions' => 'أبعاد الترخيص المهني يجب أن تكون بين 300x200 و 3000x3000 بكسل',

            // Syndicate Card
            'syndicate_card.required' => 'كارنيه النقابة مطلوب',
            'syndicate_card.image' => 'كارنيه النقابة يجب أن يكون صورة',
            'syndicate_card.mimes' => 'كارنيه النقابة يجب أن يكون بصيغة: png, jpg, jpeg, webp',
            'syndicate_card.max' => 'حجم كارنيه النقابة يجب ألا يتجاوز 5 ميجابايت',
            'syndicate_card.dimensions' => 'أبعاد كارنيه النقابة يجب أن تكون بين 300x200 و 3000x3000 بكسل',

            // Organization Photos (Multiple)
            'photo.array' => 'صور المنظمة يجب أن تكون مصفوفة',
            'photo.*.image' => 'كل ملف من صور المنظمة يجب أن يكون صورة',
            'photo.*.mimes' => 'صور المنظمة يجب أن تكون بصيغة: jpeg, png, jpg, gif',
            'photo.*.max' => 'حجم كل صورة من صور المنظمة يجب ألا يتجاوز 5 ميجابايت',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'first_name' => 'الاسم الأول',
            'last_name' => 'اسم العائلة',
            'phone' => 'رقم الهاتف',
            'address' => 'العنوان',
            'email' => 'البريد الإلكتروني',
            'about_me' => 'نبذة عني',
            'id_number' => 'رقم الهوية',
            'job_title_id' => 'المسمى الوظيفي',
            'area_id' => 'المنطقة',
            'organization_name' => 'اسم المنظمة',
            'organization_phone_first' => 'رقم هاتف المنظمة الأول',
            'organization_phone_second' => 'رقم هاتف المنظمة الثاني',
            'organization_phone_third' => 'رقم هاتف المنظمة الثالث',
            'organization_location_url' => 'رابط موقع المنظمة',
            'building_number' => 'رقم المبنى',
            'floor_number' => 'رقم الطابق',
            'apartment_number' => 'رقم الشقة',
            'personal_image' => 'الصورة الشخصية',
            'logo' => 'شعار المنظمة',
            'id_image_front' => 'صورة الهوية (الوجه الأمامي)',
            'id_image_back' => 'صورة الهوية (الوجه الخلفي)',
            'graduation_certificate' => 'شهادة التخرج',
            'professional_license' => 'الترخيص المهني',
            'syndicate_card' => 'كارنيه النقابة',
            'photo' => 'صور المنظمة',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // قائمة حقول الصور
            $imageFields = [
                'personal_image' => 'الصورة الشخصية',
                'logo' => 'شعار المنظمة',
                'id_image_front' => 'صورة الهوية (الوجه الأمامي)',
                'id_image_back' => 'صورة الهوية (الوجه الخلفي)',
                'graduation_certificate' => 'شهادة التخرج',
                'professional_license' => 'الترخيص المهني',
                'syndicate_card' => 'كارنيه النقابة'
            ];

            $allowedMimes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];

            // التحقق من كل حقل صورة
            foreach ($imageFields as $field => $fieldName) {
                if ($this->hasFile($field)) {
                    $file = $this->file($field);
                    $mimeType = $file->getMimeType();

                    // التحقق من نوع الملف
                    if (!in_array($mimeType, $allowedMimes)) {
                        $validator->errors()->add($field, "{$fieldName}: نوع الملف غير مسموح به. الأنواع المسموحة: PNG, JPG, JPEG, WEBP");
                    }

                    // التحقق من صلاحية الصورة
                    try {
                        $imageInfo = @getimagesize($file->getRealPath());
                        if ($imageInfo === false) {
                            $validator->errors()->add($field, "{$fieldName}: الملف ليس صورة صالحة");
                        }
                    } catch (\Exception $e) {
                        $validator->errors()->add($field, "{$fieldName}: فشل التحقق من الصورة. تأكد من أن الملف صورة صحيحة");
                    }
                }
            }

            // التحقق من صور المنظمة المتعددة
            if ($this->hasFile('photo')) {
                foreach ($this->file('photo') as $index => $photo) {
                    $mimeType = $photo->getMimeType();

                    if (!in_array($mimeType, $allowedMimes)) {
                        $validator->errors()->add("photo.{$index}", "صورة المنظمة رقم " . ($index + 1) . ": نوع الملف غير مسموح به");
                    }

                    try {
                        $imageInfo = @getimagesize($photo->getRealPath());
                        if ($imageInfo === false) {
                            $validator->errors()->add("photo.{$index}", "صورة المنظمة رقم " . ($index + 1) . ": الملف ليس صورة صالحة");
                        }
                    } catch (\Exception $e) {
                        $validator->errors()->add("photo.{$index}", "صورة المنظمة رقم " . ($index + 1) . ": فشل التحقق من الصورة");
                    }
                }
            }
        });
    }
}
