<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompliantResourse extends JsonResource
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
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => $this->status,
            // 'user' => new UserResource($this->user),
            // need to return relies to this compliant
            'replies' => CompliantRepliesResource::collection($this->compliantReplies)
        ];
    }
}
