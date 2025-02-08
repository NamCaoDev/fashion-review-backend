<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'type' => $this->type,
            'founder' => $this->founder,
            'addresses' => $this->addresses,
            'logo' => $this->logo,
            'products_count' => $this->whenCounted('products'),
            'social_links' => $this->social_links,
            'created_at' => $this->created_at?->format('d/m/Y H:i:s') ?? "",
            'updated_at' => $this->updated_at?->format('d/m/Y H:i:s') ?? "",
            'established_at' => $this->established_at?->format('d/m/Y H:i:s') ?? ""
        ];
    }
}
