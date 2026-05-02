<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'equipment' => new EquipmentResource($this->whenLoaded('equipment')),
            'user' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ],
            'assigned_at' => optional($this->assigned_at)?->toDateString(),
            'due_at' => optional($this->due_at)?->toDateString(),
            'returned_at' => optional($this->returned_at)?->toDateString(),
            'notes' => $this->notes,
            'created_at' => optional($this->created_at)?->toISOString(),
            'updated_at' => optional($this->updated_at)?->toISOString(),
        ];
    }
}
