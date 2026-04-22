<?php
namespace App\Services\Service;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\GetCategoryResource;
use App\Repositories\IRepo\ICategoryRepository;
use App\Services\IService\ICategoryService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryService implements ICategoryService {
    private ICategoryRepository $_categoryRepo;
    public function __construct(ICategoryRepository $categoryRepo)
    {
        $this->_categoryRepo = $categoryRepo;
    }
    // get all cats for user or admin
    public function GetAllCategories($user_id =null){
        $categories = $this->_categoryRepo->GetAll($user_id);
        if(!$categories || count($categories) == 0)
            return null;
        return GetCategoryResource::collection($categories)->resolve();
    }
    // get cat by id for user
    public function GetCategoryById(int $id , Request $req){
        $cat = $this->_categoryRepo->GetById($id , $req->user()->id);
        if($cat == null)
            return null;
        $catDTO = new GetCategoryResource($cat);
        return $catDTO->resolve();
    }






    // create cat by admin
    public function CreateCategory(StoreCategoryRequest $request){
        $request->merge(['admin_id' => $request->user()->id]);
        $cat = $request->toArray();
        try {
            return $this->_categoryRepo->Create($cat);
        } catch (\Exception $ex) {
            return false;
        }
    }
    // update cat by admin
    public function UpdateCategory(UpdateCategoryRequest $request, $id)
    {
        $cat = $this->_categoryRepo->GetById($id , $request->user()->id);
        $updatedCat = $request->toArray();
        if ($cat) {
            try {
                $this->_categoryRepo->Update($updatedCat, $id);
                $cat = $this->_categoryRepo->GetById($id , $request->user()->id);
                return $cat;
            } catch (\Exception $ex) {
                return false;
            }
        }
        return new NotFoundHttpException();
    }
    // delete cat by admin
    public function DeleteCategory($id , Request $req)
    {
        $cat = $this->_categoryRepo->GetById($id , $req->user()->id);

        if ($cat) {
            try {
                return $this->_categoryRepo->Delete($id);
            } catch (\Exception $ex) {
                return false;
            }
        }
        return new NotFoundHttpException();
    }

    // show and hide category for admin
    public function ShowCategory($id, Request $req){
        $cat = $this->_categoryRepo->GetById($id , $req->user()->id);
        if($cat){
            $cat->is_published = !$cat->is_published;
            $cat->save();
            return $cat;
        }
        return new NotFoundHttpException();
    }


    // public function GetAllPublishedCategories(){
    //     $categories = $this->_categoryRepo->GetAllPublished();
    //     if(!$categories || count($categories) == 0)
    //         return null;
    //     return GetCategoryResource::collection($categories)->resolve();
    // }


}









?>
