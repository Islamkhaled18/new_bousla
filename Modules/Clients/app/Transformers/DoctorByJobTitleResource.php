<?php

namespace Modules\Clients\app\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorByJobTitleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'nick_name' => $this->nick_name,
            'phone' => $this->phone,
            'email' => $this->email,

            // Job Title
            'job_title' => [
                'id' => $this->jobTitle?->id,
                'name' => $this->jobTitle?->name,
            ],

            // Area & City
            'area' => [
                'id' => $this->area?->id,
                'name' => $this->area?->name ?? null,
            ],

            // Organization Info

            'organization_name' => $this->organization_name,
            'organization_phone_first' =>   $this->organization_phone_first,
            'organization_phone_second' =>    $this->organization_phone_second,
            'organization_phone_third' =>    $this->organization_phone_third,
            'organization_location_url' => $this->organization_location_url,
            'organization_address' => $this->address,
            'organization_building_number' => $this->building_number,
            'organization_floor_number' => $this->floor_number,
            'organization_apartment_number' => $this->apartment_number,


            // About
            'about_me' => $this->about_me,

            // Images
            'images' => [
                'personal_image' => $this->personal_image ? url('storage/' . $this->personal_image) : asset('main_images/logo.jpeg'),
                'logo' => $this->logo ? url('storage/' . $this->logo) : asset('main_images/logo.jpeg'),
                'gallery' => $this->images->isNotEmpty()
                    ? $this->images->map(function ($image) {
                        return url('storage/' . $image->photo);
                    })
                    : [asset('main_images/logo.jpeg')],
            ],

            'documents' => [
                'graduation_certificate' => $this->graduation_certificate ? url('storage/' . $this->graduation_certificate) : asset('main_images/logo.jpeg'),
                'professional_license' => $this->professional_license ? url('storage/' . $this->professional_license) : asset('main_images/logo.jpeg'),
                'syndicate_card' => $this->syndicate_card ? url('storage/' . $this->syndicate_card) : asset('main_images/logo.jpeg'),
            ],

            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
