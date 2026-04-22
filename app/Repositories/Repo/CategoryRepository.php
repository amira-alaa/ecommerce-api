<?php
namespace App\Repositories\Repo;

use App\Models\Category;
use App\Repositories\IRepo\ICategoryRepository;

class CategoryRepository implements ICategoryRepository{

    // user
    public function GetAll($user_id){
        if($user_id == 3)
            return Category::with(['products', 'admin'])->get();
        return Category::with(['products', 'admin'])->where('is_published' , 1)->get();

    }

    public function GetById($id , $user_id){
        if($user_id == 3)
            return Category::with(['products', 'admin'])->find($id);
        return Category::with(['products', 'admin'])->where('is_published' , 1)->find($id);
    }





    // admin
    public function Create($category){
        return Category::create($category);
    }
    public function Update($category , $id){
        return Category::findOrFail($id)->update($category);
    }
    public function Delete($id){
        return Category::findOrFail($id)->delete();
    }


}












?>
