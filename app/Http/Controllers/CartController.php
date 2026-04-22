<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddItemRequest;
use App\Models\Cart;
use App\Services\IService\ICartService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartController extends Controller
{
    private ICartService $_cartService;
    public function __construct(ICartService $cartService)
    {
        $this->_cartService = $cartService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get cart
        $cart = $this->_cartService->GetCartForUser($request);
        if(!$cart)
            return response()->json([
                'message' => 'No Available Cart'
            ]);
        return response()->json([
                'data' => $cart,
                'success' => true
                            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddItemRequest $request)
    {
        // add item to cart
        // return $request;
        $cart = $this->_cartService->AddItemToCart($request);
        // return $cart;
        if($cart != null)
            return response()->json([
                                    'data' => $cart , 'message' => 'item added successfully', 'success' => true]);
        return response()->json([
                                    'message' => 'Cannot Add this Item to cart .' ,
                                    'data' => $cart , 'success' => false]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function decrement(Request $request , $product_id){
        $res = $this->_cartService->DecrementItemInCart($request , $product_id);
        // return $res;
        if($res instanceof NotFoundHttpException)
            return response()->json([
                                    'message' => 'Item is Not Found' , 'success' => false]);
        //
        if($res)
            return response()->json([
                                    'data' => $res ,'message' => 'Item Deleted SuccessFully' , 'success' => true]);
        return response()->json([
                                    'message' => 'Cannot Delete this Item to cart .' , 'success' => false]);
    }
    public function destroy(Request $request , $product_id)
    {
        //delete item from cart
        $res = $this->_cartService->DeleteItemFromCart($request , $product_id);
        // return $res;
        if($res instanceof NotFoundHttpException)
            return response()->json([
                                    'message' => 'Item is Not Found' , 'success' => false]);
        //
        if($res)
            return response()->json([
                                    'message' => 'Item Deleted SuccessFully' , 'success' => true]);
        return response()->json([
                                    'message' => 'Cannot Delete this Item to cart .' , 'success' => false]);
    }

    public function checkout(Request $request){
        // return "true";
        $res = $this->_cartService->checkOut($request);
        // return $res;
        if($res)
            return response()->json([
                            'message' => 'Order Created Successfully' ,
                            'data' => $res , 'success' =>true]);
        return response()->json([
                            'message' => 'Failed To Create Order' , 'success' =>false]);

    }
}
