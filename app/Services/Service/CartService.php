<?php
namespace App\Services\Service;

use App\Http\Requests\Cart\AddItemRequest;
use App\Http\Resources\Cart\GetCartResource;
use App\Http\Resources\Order\GetOrderResource;
use App\Repositories\IRepo\ICartRepository;
use App\Repositories\IRepo\IOrderProductsRepository;
use App\Repositories\IRepo\IOrderRepository;
use App\Services\IService\ICartService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartService implements ICartService{
    private ICartRepository $_cartRepo;
    private IOrderRepository $_orderRepo;
    private IOrderProductsRepository $_orderProdRepo;
    public function __construct(ICartRepository $cartRepo ,
                                 IOrderRepository $orderRepo ,
                                 IOrderProductsRepository $orderProdRepo)
    {
        $this->_cartRepo = $cartRepo;
        $this->_orderRepo = $orderRepo;
        $this->_orderProdRepo = $orderProdRepo;
    }
    public function GetCartForUser(Request $request){
        $cart = $this->_cartRepo->GetCart($request->user()->id);
        $total_price = $cart->sum(function($item){
            return $item->product->price * $item->quantity;
        });
        // return $cart;
        if($cart == null || count($cart) == 0)
            return null;
        return [ 'data' => GetCartResource::collection($cart)->resolve() , 'total_price' => $total_price];
    }

    public function AddItemToCart(AddItemRequest $req){
        $req->merge(['user_id'=> $req->user()->id , 'quantity' => $req->quantity]);

        $newitem = $req->toArray();
        $item = $this->_cartRepo->GetItem($req->user_id , $req->product_id);
        // 1    , 5      5-1 = 4         5    , 2      2-5=-3
        if($item != null){
            $product_inStock = $item->product->quantity_in_stock;
            $added_quantity = $req->quantity - $item->quantity;


            if($item->quantity >= $product_inStock && $added_quantity > 0)
                return null;
            $item->quantity += $added_quantity;
            $item->save();

            $retitem = new GetCartResource($item) ;
            return $retitem->resolve();
        }
        else{

            try{
                return $this->_cartRepo->AddItem($newitem);
            }catch(\Exception $ex){
                return $ex;
            }
        }

        // $total_price = $item
    }

    public function DecrementItemInCart(Request $req , $product_id){
        $item = $this->_cartRepo->GetItem($req->user()->id , $product_id);
        if($item)
            if($item->quantity < 2 && $item->quantity >= 0){
                try{
                    $this->_cartRepo->DeleteItem($item);
                    return true;
                }catch(\Exception $e){
                    return false;
                }
            }else{
                $item->decrement('quantity');
                $retitem = new GetCartResource($item);
                return $retitem->resolve();
            }
        return new NotFoundHttpException();
    }
    public function DeleteItemFromCart(Request $req , $product_id){
        $item = $this->_cartRepo->GetItem($req->user()->id , $product_id);
        if($item)
        {
            try{
                $this->_cartRepo->DeleteItem($item);
                return true;
            }catch(\Exception $e){
                return false;
            }
        }
        return new NotFoundHttpException();
    }

    public function checkOut(Request $req){
        $cart = $this->_cartRepo->GetCart($req->user()->id);
        $total_price = 0;
        $orderProd = [];

        // calculate Total Price
        foreach($cart as $item){
            $total_price += ($item->product->price * $item->quantity);

        }

        // Create Order to insert to db
        $order = ['user_id' => $req->user()->id ,
                'total_price' => $total_price];
        try{
            // insert order to db

            $neworder = $this->_orderRepo->Create($order);
            // decrement quantity
            // insert products and order to db
            foreach($cart as $item){
                $orderProd = ['order_id' => $neworder->id ,
                 'product_id' => $item->product_id ,
                 'product_quantity' => $item->quantity ];

                $this->_orderProdRepo->Create($orderProd);
                $item->product->decrement('quantity_in_stock' , $item->quantity);
            }
            // delete cart
            $this->_cartRepo->DeleteCart($req->user()->id);
            // get Order
            $ord =$this->_orderRepo->GetOrder($req->user()->id)->last();
            $lastOrd = new GetOrderResource($ord);
            return $lastOrd->resolve();
        }catch(\Exception $e){
            return false;
        }
    }

}



?>
