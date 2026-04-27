<?php
namespace App\Repositories\Repo;

use App\Models\Product;
use App\Repositories\IRepo\IProductRepository;

class ProductRepository implements IProductRepository{


    // get all products vendor or user or admin
    public function GetAll($user_id){
        if($user_id == 2)
            $products = Product::with(['category','vendor'])->where('vendor_id' , $user_id)->get();
        elseif($user_id == 3)
            $products = Product::with(['category','vendor'])->get();
        else
            $products = Product::with(['category','vendor'])->where('is_published' , 1)->get();
        return $products;
    }
    public function GetById($product_id , $user_id = null)
    {
        if($user_id == 2)
            $product = Product::with(['category','vendor'])->where('vendor_id' , $user_id)->find($product_id);
        elseif($user_id == 3)
            $product = Product::with(['category','vendor'])->find($product_id);
        else
            $product = Product::with(['category','vendor'])->where('is_published' , 1)->find($product_id);

        return $product;
    }
    // get latest products for user
    public function GetLatestProducts(){
        return Product::with(['category','vendor'])->where('is_published' , 1)->latest()->take(6)->get();
    }
    // create product for vendor
    public function Create($product){
        return Product::create($product);
    }
    // update product for vendor
    public function Update($product , $id){
        return Product::findOrFail($id)->update($product);
    }
    // delete product for vendor
    public function Delete($id){
        return Product::findOrFail($id)->delete();
    }
    // get products by category id
    public function GetProductsByCatId($cat_id){
        return Product::with(['category','vendor'])->where('category_id' , $cat_id)->get();
    }

}



?>
