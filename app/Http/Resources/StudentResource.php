<?php

namespace App\Http\Resources;

use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'nisn' => $this->nisn,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
            'email' => $this->email,
            'class_room_id' => $this->class_room_id,
            "image" => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'classRoom' => new ClassRoomResource($this->whenLoaded('classRoom')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
