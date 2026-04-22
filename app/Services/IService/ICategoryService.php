<?php
namespace App\Services\IService;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use Illuminate\Http\Request;

interface ICategoryService{
    public function GetAllCategories($user_id =null);
    // public function GetAllPublishedCategories();

    public function GetCategoryById(int $id , Request $req);
    public function CreateCategory(StoreCategoryRequest $request);
    public function UpdateCategory(UpdateCategoryRequest $request , $id);
    public function DeleteCategory($id , Request $req);
    public function ShowCategory($id , Request $req);
}




?>
