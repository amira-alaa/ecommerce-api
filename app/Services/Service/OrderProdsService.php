<?php
namespace App\Services\Service;

use App\Http\Resources\OrderProducts\GetOrderProductsResource;
use App\Repositories\IRepo\IOrderProductsRepository;
use App\Services\IService\IOrderProdsService;
use Illuminate\Http\Request;

class OrderProdsService implements IOrderProdsService{
    private IOrderProductsRepository $_OPRepo;
    public function __construct(IOrderProductsRepository $OPRepo)
    {
        $this->_OPRepo = $OPRepo;
    }

    public function GetAllOrderProdsForVendor(Request $request){
        $OrdProds = $this->_OPRepo->GetAll($request->user()->id);
        if(count($OrdProds) == 0)
            return null;
        return $OrdProds;
        // return GetOrderProductsResource::collection($OrdProds)->resolve();
        // return new GetOrderProductsResource($OrdProds);
    }

}



?>
