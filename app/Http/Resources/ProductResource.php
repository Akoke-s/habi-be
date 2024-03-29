<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'image' => $this->image,
            'description' => $this->description,
            'category_type' => $this->category_type,
            'department' => $this->department,
            'colors' => $this->colors,
            'stocks' => StockResource::collection($this->stocks),
            'sizes' => $this->sizes,
            'status' => $this->status,
            'slug' => $this->slug,
            'created_at' => $this->created,
            'updated_at' => $this->updated
        ];
    }
}
