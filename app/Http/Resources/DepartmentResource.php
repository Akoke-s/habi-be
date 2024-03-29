<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'slug' => $this->slug,
            'category' => $this->category,
            'types' => CategoryTypeResource::collection($this->types),
            'products' => ProductResource::collection($this->products),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
