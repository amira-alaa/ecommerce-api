<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cart_id' => $this->id,
            'product_id' => $this->product->id,
            'user_id' => $this->user->id,
            'product_name' => $this->product->name ,
            'product_price' => $this->product->price,
            'user_name' => $this->user->name,
            'quantity' => $this->quantity,
            'total_product_price' => $this->product->price * $this->quantity
        ];
    }
}
