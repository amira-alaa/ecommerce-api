<?php

namespace App\Http\Resources\OrderProducts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetOrderProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return [
        //     'order_id' => $this->order,

        //     'products' => $this->orderProducts->map(function ($item) {
        //         return [
        //             'product_id'   => $item->product->id,
        //             'product_name' => $item->product->name,
        //             'quantity'     => $item->quantity,
        //             'price'        => $item->product->price,
        //         ];
        //     })
        // ];
        return [
            'orders' => $this->order,
            // 'products' => $this->order->products,
            // 'Product_name' => $this->product->name,
            // 'user_name',

        ];
    }
}
