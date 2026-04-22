<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'category_name' => $this->name,
            'admin_name' => $this->admin->name,
            'is_publish' => $this->is_published ? "Appeared" : "DisAppeared" ,
            'products_count' => $this->products->count(),
            'products' => $this->products
        ];
    }
}
