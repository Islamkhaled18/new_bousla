<?php

namespace Modules\Clients\app\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class DoctorFilterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,

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
            'organization_address' => Str::limit($this->address, 15, '...'),
            'clinic_fees' => $this->clinic_fees,

            // Image
            'personal_image' => $this->personal_image ? url('storage/' . $this->personal_image) : asset('main_images/logo.jpeg'),



        ];
    }
}
