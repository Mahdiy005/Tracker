<?php

namespace App\Http\Resources;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFAdminResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $this->image,
            'serial' => $this->serial,
            'position' => $this->position,
            'role' => $this->role,
            'attendances' => AttendanceResource::collection($this->attendances),
            'complaints' => CompliantResourse::collection($this->compliants),
            'acitvity_log' => ActivityLogResource::collection($this->actvityLogs),
            'number_of_vilations' => $this->vilations->count(),
            'number_of_attend' => $this->attendances->filter(function ($attendance) {
                return $attendance->status === 'attend';
            })->count(),
            'number_of_absent' => $this->attendances->filter(function ($attendance) {
                return $attendance->status === 'absent';
            })->count(),
            'number_of_complaints' => $this->compliants->count(),
        ];
    }
}
