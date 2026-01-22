<?php

namespace Modules\Clients\app\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobTitleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,

            // Web icon (Font Awesome)
            'icon' => [
                'class' => $this->icon,
                'color' => $this->icon_color,
                'backgroundColor' => $this->bg_color,
            ],

            // Mobile icon (Flutter Material Icons)
            'mobileIcon' => [
                'codePoint' => hexdec(str_replace('0x', '', $this->icon_unicode ?? '0xe3f0')),
                'fontFamily' => $this->icon_family ?? 'MaterialIcons',
                'color' => $this->icon_color,
                'backgroundColor' => $this->bg_color,
            ],
        ];
    }
}
