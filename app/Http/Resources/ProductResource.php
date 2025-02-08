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
            'description' => $this->description,
            'images' => $this->images,
            'origin_price' => $this->origin_price,
            'current_price' => $this->current_price,
            'materials' => $this->materials,
            'price_symbol' => $this->price_symbol,
            'product_type' => $this->product_type,
            'in_stock' => $this->in_stock,
            'buy_links' => $this->buy_links,
            'brand' => $this->brand,
            'created_at' => $this->created_at?->format('d/m/Y H:i:s') ?? "",
            'updated_at' => $this->updated_at?->format('d/m/Y H:i:s') ?? "",
        ];
    }
}
