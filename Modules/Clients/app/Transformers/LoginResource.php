<?php

namespace Modules\Clients\app\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'slug' => $this->slug,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'nick_name' => $this->nick_name,
            'phone' => $this->phone,
            'email' => $this->email ?? 'لا يوجد',
            'gender' => $this->gender == 'male' ? 'ذكر' : 'أنثى',
            'is_active' => $this->is_active,
            'address' => $this->address ?? 'لا يوجد',
            'id_number' => $this->id_number ?? 'لا يوجد',
            'area_id' => $this->area_id ?? 'لا يوجد',
            'personal_image' => $this->personal_image ? asset($this->personal_image) : asset('main_images/logo.jpeg'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
