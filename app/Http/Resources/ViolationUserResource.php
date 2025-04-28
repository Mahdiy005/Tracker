<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ViolationUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => date_format($this->created_at, 'Y-m-d'),
            'type' => $this->violation_type,
            'detection type' => $this->detected_by,
            'image' => $this->image,
            'user' => new UserResource($this->user),
        ];
    }
}
