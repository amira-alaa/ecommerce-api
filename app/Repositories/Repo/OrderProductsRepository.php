<?php
namespace App\Repositories\Repo;

use App\Models\Order;
use App\Models\OrderProducts;
use App\Repositories\IRepo\IOrderProductsRepository;

class OrderproductsRepository implements IOrderProductsRepository{

    public function Create($orderProduct){
        return OrderProducts::create($orderProduct);
    }
    public function GetAll($vendor_id)
    {
        return Order::with(['products' => function ($query) use ($vendor_id) {
            // $query->whereHas('category', function ($q) use ($vendor_id) {
            //     $q->where('', $vendor_id);
            // });
            $query->where('vendor_id' , $vendor_id);
        }])
        ->get()
        ->map(function ($order) {

            $totalPrice = $order->products->sum(function ($product) {
                return $product->price * $product->pivot->product_quantity;
            });

            return [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'products' => $order->products,
                'total_price' => $totalPrice,
            ];
        });
    }


}



?>
