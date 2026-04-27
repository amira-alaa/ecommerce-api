<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\IService\IProductService;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    private IProductService $_productService;
    public function __construct(IProductService $productService)
    {
        $this->_productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all products for user & vendor
        dd($request->user()->id);
        if(isset($request->user()->id))
            $products = $this->_productService->GetAllProducts($request->user()->id);
        else
            $products = $this->_productService->GetAllProducts();
        if(!$products)
            return response()->json([
                                'message' => 'No Available Products',
                                'success' => false
                                    ])->header('Access-Control-Allow-Origin', '*');
        return response()->json([
                                'data' => $products,
                                'success' => true
                                    ])->header('Access-Control-Allow-Origin', '*');
    }


    public function GetLatestPros(){
        $products = $this->_productService->GetLatestProducts();
        if(!$products)
            return response()->json([
                                'message' => 'No Available Products',
                                'success' => false
                                    ])->header('Access-Control-Allow-Origin', '*');
        return response()->json([
                                'data' => $products,
                                'success' => true
                                    ])->header('Access-Control-Allow-Origin', '*');
    }
    public function GetProductsByCat($cat_id){
        $products = $this->_productService->GetAllProductsByCatId($cat_id);
        if(!$products)
            return response()->json([
                                'message' => 'No Available Products',
                                'success' => false
                                    ])->header('Access-Control-Allow-Origin', '*');
        return response()->json([
                                'data' => $products,
                                'success' => true
                                    ])->header('Access-Control-Allow-Origin', '*');
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request , $id)
    {
        // get specific product
        if(isset($request->user()->id))
            $product= $this->_productService->GetProductById($id, $request->user()->id);
        else
            $product= $this->_productService->GetProductById($id);


        if(!$product)
            return response()->json([
                                'message' => 'Product is Not Found',
                                'success' => false
                                    ] , 404);
        return response()->json([
                                'data' => $product,
                                'success' => true
                                    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // insert products for vendor
        $res = $this->_productService->CreateProduct($request);
        if($res)
            return response()->json([
                                'message' => "Product Created Successfully",
                                'data' => $res,
                                'success' => true]);
        return response()->json([
            'message' => 'Failed To Create Product',
            'data' => $res ,
            'success' => false
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        // update products for vendor
        $res = $this->_productService->UpdateProduct($request , $id);
        if($res instanceof NotFoundHttpException)
            return response()->json([
                                'message' => "Product is Not Found",
                                'success' => false] , 404);
        //
        if($res)
            return response()->json([
                                'message' => "Product Updated Successfully",
                                'success' => true]);
        return response()->json([
            'message' => 'Failed To Update Product',
            'success' => false
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request , $id)
    {
        // delete products for vendor
        $res = $this->_productService->DeleteProduct($request , $id);
        if($res instanceof NotFoundHttpException)
            return response()->json([
                                'message' => "Product is Not Found",
                                'success' => false] , 404);
        //
        if($res)
            return response()->json([
                                'message' => "Product Deleted Successfully",
                                'success' => true]);
        return response()->json([
            'message' => 'Failed To Delete Product',
            'success' => false
        ]);
    }

    public function publishProduct(Request $request , $id){
        $res = $this->_productService->PublishProduct($id , $request);
        if($res instanceof NotFoundHttpException)
            return response()->json([
                                'message' => "Not Found Product",
                                'success' => false] , 404);
        //
        if($res)
            return response()->json([
                                'message' => 'Product '. ($res->is_published ? 'Published' : 'Deleted'). ' Successfully',
                                'success' => true]);
        return response()->json([
            'message' => 'Failed To Publish or delete Product',
            'success' => false
        ]);
    }
}
