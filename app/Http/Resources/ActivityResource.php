<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'description' => $this->description,
            'amount' => number_format($this->amount, 0, ',', '.'),
            'due_date' => $this->due_date->format('d M Y'), // Format tanggal sesuai preferensi
            'created_at' => $this->created_at->diffForHumans(), // Format waktu relatif
            'updated_at' => $this->updated_at->diffForHumans(), // Format waktu relatif
            'students' => StudentResource::collection($this->whenLoaded('students')),
        ];
    }
}
