<?php
namespace App\Services\IService;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Http\Request;

interface IProductService{
    public function GetAllProducts(Request $request);
    public function GetLatestProducts();
    public function GetAllProductsByCatId($cat_id);
    public function GetProductById(Request $request ,int $id);
    public function CreateProduct(StoreProductRequest $request);
    public function UpdateProduct(UpdateProductRequest $request , $id);
    public function DeleteProduct(Request $request ,$id);
    public function PublishProduct($id, Request $req);
}




?>
