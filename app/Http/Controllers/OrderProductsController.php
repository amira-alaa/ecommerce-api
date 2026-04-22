<?php

namespace App\Http\Controllers;

use App\Models\OrderProducts;
use App\Services\IService\IOrderProdsService;
use Illuminate\Http\Request;

class OrderProductsController extends Controller
{
    private IOrderProdsService $_OPService;
    public function __construct(IOrderProdsService $OPService)
    {
        $this->_OPService = $OPService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all orders For Vendor
        // return $request->user()->id;
        $orderProds =$this->_OPService->GetAllOrderProdsForVendor($request);
        if(!$orderProds)
            return response()->json([
                                'message' => 'No Available Order_Products',
                                'success' => false
                                    ]);
        return response()->json([
                                'data' => $orderProds,
                                'success' => true
                                    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderProducts $orderProducts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderProducts $orderProducts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderProducts $orderProducts)
    {
        //
    }
}
