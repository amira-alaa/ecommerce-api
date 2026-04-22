<?php
namespace App\Services\Service;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\GetProductResource;
use App\Repositories\IRepo\IProductRepository;
use App\Services\IService\IProductService;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService implements IProductService{
    private IProductRepository $_productRepo;
    public function __construct(IProductRepository $productRepo)
    {
        $this->_productRepo = $productRepo;
    }
    public function GetAllProducts(Request $request){

        $products = $this->_productRepo->GetAll($request->user()->id);
        if(!$products || count($products) == 0)
            return null;
        return GetProductResource::collection($products)->resolve();
    }

    public function GetLatestProducts(){
        $products = $this->_productRepo->GetLatestProducts();
        if(!$products || count($products) == 0)
            return null;
        return GetProductResource::collection($products)->resolve();
    }
    public function GetAllProductsByCatId($cat_id){
        $products = $this->_productRepo->GetProductsByCatId($cat_id);
        if(count($products) == 0)
            return null;
        return GetProductResource::collection($products)->resolve() ;
    }

    public function GetProductById(Request $request , int $id){
        $product = $this->_productRepo->GetById($id , $request->user()->id);

        if(!$product)
            return null;
        $productDTO =new GetProductResource($product);
        return $productDTO->resolve();
    }
    public function CreateProduct(StoreProductRequest $request){
        $request->merge(['vendor_id' => $request->user()->id]);
        $product = $request->toArray();
        // return $product;
        try{
            return $this->_productRepo->Create($product);
        }catch(Exception $ex){
            return $ex;
        }
    }
    public function UpdateProduct(UpdateProductRequest $request , $id){
        $product = $this->_productRepo->GetById($id , $request->user()->id);

        $updatedProduct = $request->toArray();
        if($product){
            try{
                $this->_productRepo->Update($updatedProduct, $id);
                return true;
            }catch(Exception $ex){
                return false;
            }

        }
        return new NotFoundHttpException();
    }
    public function DeleteProduct(Request $request , $id){
        $product = $this->_productRepo->GetById($id , $request->user()->id);
        if($product){
            try{
                $this->_productRepo->Delete($id);
                return true;
            }catch(Exception $ex){
                return false;
            }
        }
        return new NotFoundHttpException();

    }

    public function PublishProduct($id, Request $req){
        $product = $this->_productRepo->GetById($id , $req->user()->id);
        if($product){
            $product->is_published = !$product->is_published;
            $product->save();
            return $product;
        }
        return new NotFoundHttpException();
    }
}








?>
