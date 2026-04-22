<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetProductResource extends JsonResource
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
            'category_id' => $this->category?->id,
            'product_name' => $this->name,
            'category_name' => $this->category?->name,
            'price' => $this->price,
            'quantity' => $this->quantity_in_stock,
            'isPublished' => $this->is_published ? "Published" : "Not Published",
            'in_stock' => $this->quantity_in_stock > 0 ? "In Stock" : "Out Of Stock"
        ];
    }
}
