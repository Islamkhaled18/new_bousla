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
        ];

        return [
            'first_name' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'min:3',
                'max:191',
            ],
            'last_name' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'min:3',
                'max:191',
            ],
            'phone' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'regex:/^01[0-9]{9}$/',
                Rule::unique('users', 'phone')->ignore($joinRequestId)
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
                Rule::unique('users', 'email')->ignore($joinRequestId)
            ],
            'is_available_for_home_visits' => [
                'nullable',
                'in:0,1',
            ],
            'is_accept_terms' => [
                'required',
                'in:1',
            ],
            'gender' => [
                $isCreating ? 'required' : 'sometimes',
                'in:male,female',
            ],
            'about_me' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'max:191',
            ],
            'id_number' => [
                $isCreating ? 'required' : 'sometimes',
                'string',
                'regex:/^[0-9]{14}$/',
                Rule::unique('users', 'id_number')->ignore($joinRequestId)
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
            'clinic_fees' => [
                 $isCreating ? 'required' : 'sometimes',
                'numeric',
                'min:0',
            ],
            'home_visit_fees' => [
                'required_if:is_available_for_home_visits,1',
                'numeric',
                'min:0',
                'nullable',
            ],
            'urgent_fees' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'urgent_fees_again' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'clinic_fees_again' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'home_visit_fees_again' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'public_name' => [
                'nullable',
                'string',
                'min:3',
                'max:191',
            ],
            'address_label' => [
                'nullable',
                'string',
                'min:3',
                'max:191',
            ],
            'facebook_url' => [
                'nullable',
                'url',
                'max:191',
            ],
            'instagram_url' => [
                'nullable',
                'url',
                'max:191',
            ],
            'date_of_birth' => [
                'nullable',
                'date',
            ],

            // Images Validation

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

            // ================================
            // Doctor Schedules Validation
            // ================================
            'schedules' => 'nullable|array',
            'schedules.*.day_of_week' => [
                'required_with:schedules',
                'in:sunday,monday,tuesday,wednesday,thursday,friday,saturday'
            ],
            'schedules.*.from_time' => [
                'required_with:schedules',
                'date_format:H:i',
            ],
            'schedules.*.to_time' => [
                'required_with:schedules',
                'date_format:H:i',
                'after:schedules.*.from_time'
            ],
            'schedules.*.booking_type' => [
                'required_with:schedules',
                'in:time_slots,hourly_capacity'
            ],
            'schedules.*.slot_duration' => [
                'required_if:schedules.*.booking_type,time_slots',
                'nullable',
                'integer',
                'min:5',
                'max:120',
                'in:5,10,15,20,30,45,60,90,120'
            ],
            'schedules.*.max_patients_per_hour' => [
                'required_if:schedules.*.booking_type,hourly_capacity',
                'nullable',
                'integer',
                'min:1',
                'max:50'
            ],
            'schedules.*.is_active' => [
                'nullable',
                'boolean'
            ],
        ];
    }

    public function messages(): array
    {
        return [

            // =====================
            // Basic Info
            // =====================
            'first_name.required' => 'الاسم الأول مطلوب',
            'first_name.string'   => 'الاسم الأول يجب أن يكون نصًا',
            'first_name.min'      => 'الاسم الأول يجب ألا يقل عن 3 حروف',
            'first_name.max'      => 'الاسم الأول يجب ألا يزيد عن 191 حرف',

            'last_name.string' => 'اسم العائلة يجب أن يكون نصًا',
            'last_name.min'    => 'اسم العائلة يجب ألا يقل عن 3 حروف',
            'last_name.max'    => 'اسم العائلة يجب ألا يزيد عن 191 حرف',

            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.string'   => 'رقم الهاتف غير صالح',
            'phone.regex'    => 'رقم الهاتف يجب أن يبدأ بـ 01 ويتكون من 11 رقم',
            'phone.unique'   => 'رقم الهاتف مستخدم بالفعل',

            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email'    => 'البريد الإلكتروني غير صالح',
            'email.max'      => 'البريد الإلكتروني طويل جدًا',
            'email.unique'   => 'البريد الإلكتروني مستخدم بالفعل',

            'gender.required' => 'النوع مطلوب',
            'gender.in'       => 'النوع يجب أن يكون ذكر أو أنثى',

            'date_of_birth.date' => 'تاريخ الميلاد غير صالح',

            // =====================
            // Terms
            // =====================
            'is_accept_terms.required' => 'يجب الموافقة على الشروط والأحكام',
            'is_accept_terms.in'       => 'يجب الموافقة على الشروط والأحكام',

            // =====================
            // Address
            // =====================
            'address.required' => 'العنوان مطلوب',
            'address.string'   => 'العنوان يجب أن يكون نصًا',
            'address.min'      => 'العنوان قصير جدًا',
            'address.max'      => 'العنوان طويل جدًا',

            'area_id.required' => 'المنطقة مطلوبة',
            'area_id.exists'   => 'المنطقة غير موجودة',

            'building_number.required' => 'رقم المبنى مطلوب',
            'floor_number.required'    => 'رقم الدور مطلوب',
            'apartment_number.required' => 'رقم الشقة مطلوب',

            // =====================
            // Job & Organization
            // =====================
            'job_title_id.required' => 'المسمى الوظيفي مطلوب',
            'job_title_id.exists'   => 'المسمى الوظيفي غير صحيح',

            'organization_name.required' => 'اسم الجهة مطلوب',
            'organization_name.string'   => 'اسم الجهة يجب أن يكون نصًا',
            'organization_name.min'      => 'اسم الجهة قصير جدًا',
            'organization_name.max'      => 'اسم الجهة طويل جدًا',

            'organization_phone_first.required' => 'رقم هاتف الجهة مطلوب',
            'organization_phone_first.regex'    => 'رقم هاتف الجهة غير صالح',

            'organization_phone_second.regex' => 'رقم الهاتف غير صالح',
            'organization_phone_third.regex'  => 'رقم الهاتف غير صالح',

            'organization_location_url.required' => 'رابط موقع الجهة مطلوب',
            'organization_location_url.url'      => 'رابط الموقع غير صالح',
            'organization_location_url.regex'    => 'الرابط يجب أن يكون من خرائط جوجل',
            'organization_location_url.max'      => 'الرابط طويل جدًا',

            // =====================
            // Identification
            // =====================
            'id_number.required' => 'الرقم القومي مطلوب',
            'id_number.regex'    => 'الرقم القومي يجب أن يتكون من 14 رقم',
            'id_number.unique'   => 'الرقم القومي مستخدم بالفعل',

            // =====================
            // About
            // =====================
            'about_me.required' => 'نبذة عنك مطلوبة',
            'about_me.string'   => 'النبذة يجب أن تكون نصًا',
            'about_me.max'      => 'النبذة طويلة جدًا',

            // =====================
            // Fees
            // =====================
            'clinic_fees.required' => 'سعر الكشف مطلوب',
            'clinic_fees.numeric'  => 'سعر الكشف يجب أن يكون رقمًا',
            'clinic_fees.min'      => 'سعر الكشف لا يمكن أن يكون أقل من صفر',

            'home_visit_fees.required_if' => 'سعر الزيارة المنزلية مطلوب',
            'home_visit_fees.numeric'     => 'سعر الزيارة المنزلية يجب أن يكون رقمًا',
            'home_visit_fees.min'         => 'سعر الزيارة المنزلية لا يمكن أن يكون أقل من صفر',

            'urgent_fees.numeric' => 'سعر الاستعجال يجب أن يكون رقمًا',
            'urgent_fees.min'     => 'سعر الاستعجال لا يمكن أن يكون أقل من صفر',

            // =====================
            // Images
            // =====================
            'personal_image.required' => 'الصورة الشخصية مطلوبة',
            'personal_image.image'    => 'الصورة الشخصية غير صالحة',
            'personal_image.mimes'    => 'صيغة الصورة غير مدعومة',
            'personal_image.max'      => 'حجم الصورة كبير جدًا',

            'logo.image' => 'اللوجو غير صالح',

            'id_image_front.required' => 'صورة البطاقة (أمام) مطلوبة',
            'id_image_back.required'  => 'صورة البطاقة (خلف) مطلوبة',

            'photo.array'   => 'الصور يجب أن تكون في صورة مصفوفة',
            'photo.*.image' => 'إحدى الصور غير صالحة',

            // =====================
            // Schedules
            // =====================
            'schedules.array' => 'المواعيد يجب أن تكون مصفوفة',

            'schedules.*.day_of_week.required_with' => 'يجب تحديد يوم العمل',
            'schedules.*.day_of_week.in'            => 'يوم العمل غير صالح',

            'schedules.*.from_time.required_with' => 'وقت البداية مطلوب',
            'schedules.*.from_time.date_format'   => 'صيغة وقت البداية غير صحيحة',

            'schedules.*.to_time.required_with' => 'وقت النهاية مطلوب',
            'schedules.*.to_time.date_format'   => 'صيغة وقت النهاية غير صحيحة',
            'schedules.*.to_time.after'         => 'وقت النهاية يجب أن يكون بعد وقت البداية',

            'schedules.*.booking_type.required_with' => 'نوع الحجز مطلوب',
            'schedules.*.booking_type.in'            => 'نوع الحجز غير صالح',

            'schedules.*.slot_duration.required_if' => 'مدة الحجز مطلوبة',
            'schedules.*.slot_duration.integer'     => 'مدة الحجز يجب أن تكون رقمًا',

            'schedules.*.max_patients_per_hour.required_if' =>
            'عدد المرضى في الساعة مطلوب',
            'schedules.*.max_patients_per_hour.integer' =>
            'عدد المرضى يجب أن يكون رقمًا',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            // =====================
            // Basic Info
            // =====================
            'first_name' => 'الاسم الأول',
            'last_name' => 'اسم العائلة',
            'phone' => 'رقم الهاتف',
            'email' => 'البريد الإلكتروني',
            'date_of_birth' => 'تاريخ الميلاد',
            'gender' => 'الجنس',
            'about_me' => 'نبذة عني',
            'public_name' => 'الاسم الظاهر للمرضى',

            // =====================
            // Address
            // =====================
            'address' => 'العنوان',
            'address_label' => 'وصف العنوان',
            'area_id' => 'المنطقة',
            'building_number' => 'رقم المبنى',
            'floor_number' => 'رقم الطابق',
            'apartment_number' => 'رقم الشقة',

            // =====================
            // Identification
            // =====================
            'id_number' => 'الرقم القومي',

            // =====================
            // Job & Organization
            // =====================
            'job_title_id' => 'المسمى الوظيفي',
            'organization_name' => 'اسم المنشأة',
            'organization_phone_first' => 'رقم هاتف المنشأة الأول',
            'organization_phone_second' => 'رقم هاتف المنشأة الثاني',
            'organization_phone_third' => 'رقم هاتف المنشأة الثالث',
            'organization_location_url' => 'رابط موقع المنشأة',

            // =====================
            // Fees
            // =====================
            'clinic_fees' => 'سعر الكشف',
            'home_visit_fees' => 'سعر الزيارة المنزلية',
            'urgent_fees' => 'سعر الكشف المستعجل',
            'clinic_fees_again' => 'سعر إعادة الكشف',
            'home_visit_fees_again' => 'سعر إعادة الزيارة المنزلية',
            'urgent_fees_again' => 'سعر إعادة الكشف المستعجل',

            // =====================
            // Terms
            // =====================
            'is_accept_terms' => 'الموافقة على الشروط والأحكام',
            'is_available_for_home_visits' => 'متاح للزيارات المنزلية',

            // =====================
            // Images
            // =====================
            'personal_image' => 'الصورة الشخصية',
            'logo' => 'شعار المنشأة',
            'id_image_front' => 'صورة البطاقة (الوجه الأمامي)',
            'id_image_back' => 'صورة البطاقة (الوجه الخلفي)',
            'graduation_certificate' => 'شهادة التخرج',
            'professional_license' => 'الترخيص المهني',
            'syndicate_card' => 'كارنيه النقابة',
            'photo' => 'صور المنشأة',
            'photo.*' => 'صورة من صور المنشأة',

            // =====================
            // Schedules
            // =====================
            'schedules' => 'مواعيد العمل',
            'schedules.*.day_of_week' => 'يوم العمل',
            'schedules.*.from_time' => 'وقت البداية',
            'schedules.*.to_time' => 'وقت النهاية',
            'schedules.*.booking_type' => 'نوع الحجز',
            'schedules.*.slot_duration' => 'مدة الحجز',
            'schedules.*.max_patients_per_hour' => 'عدد المرضى في الساعة',
            'schedules.*.is_active' => 'الحالة',
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

            // ================================
            // التحقق من مواعيد العمل (Doctor Schedules)
            // ================================
            if ($this->has('schedules') && is_array($this->schedules)) {
                $days = [];

                foreach ($this->schedules as $index => $schedule) {
                    // التحقق من عدم تكرار نفس اليوم
                    if (isset($schedule['day_of_week'])) {
                        if (in_array($schedule['day_of_week'], $days)) {
                            $validator->errors()->add("schedules.{$index}.day_of_week", "لا يمكن تكرار نفس اليوم مرتين");
                        }
                        $days[] = $schedule['day_of_week'];
                    }

                    // التحقق من أن وقت النهاية بعد وقت البداية
                    if (isset($schedule['from_time']) && isset($schedule['to_time'])) {
                        if (strtotime($schedule['to_time']) <= strtotime($schedule['from_time'])) {
                            $validator->errors()->add("schedules.{$index}.to_time", "وقت النهاية يجب أن يكون بعد وقت البداية");
                        }
                    }

                    // التحقق من أن slot_duration موجود إذا كان booking_type = time_slots
                    if (isset($schedule['booking_type']) && $schedule['booking_type'] === 'time_slots') {
                        if (empty($schedule['slot_duration'])) {
                            $validator->errors()->add("schedules.{$index}.slot_duration", "مدة الموعد مطلوبة عند اختيار نظام المواعيد المحددة");
                        }
                    }

                    // التحقق من أن max_patients_per_hour موجود إذا كان booking_type = hourly_capacity
                    if (isset($schedule['booking_type']) && $schedule['booking_type'] === 'hourly_capacity') {
                        if (empty($schedule['max_patients_per_hour'])) {
                            $validator->errors()->add("schedules.{$index}.max_patients_per_hour", "عدد المرضى بالساعة مطلوب عند اختيار نظام الحد الأقصى");
                        }
                    }
                }
            }
        });
    }
}
