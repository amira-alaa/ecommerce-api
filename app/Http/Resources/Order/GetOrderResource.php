<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetOrderResource extends JsonResource
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
            'user_name' => $this->user->name,
            'user_phone' => $this->user->phone,
            'total_price' => $this->total_price,
            'products' => $this->products->pluck(['name' , 'quantity_in_stock'])

        ];
    }
}
