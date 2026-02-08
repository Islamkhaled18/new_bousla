<?php

namespace Modules\Clients\app\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'relationship' => $this->getRelationshipInArabic(),
            'age' => $this->age,
            'gender' => $this->gender == 'male' ? 'ذكر' : 'أنثى',
            'phone' => $this->phone,
            'blood_type' => $this->blood_type ?? 'غير محدد',
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }

    private function getRelationshipInArabic(): string
    {
        $relationships = [
            'father' => 'أب',
            'mother' => 'أم',
            'sister' => 'أخت',
            'brother' => 'أخ',
        ];

        return $relationships[$this->relationship] ?? $this->relationship;
    }
}
