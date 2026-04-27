<?php

namespace App\Http\Controllers;

// use App\Models\Category;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\IService\ICategoryService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    private ICategoryService $_categoryService ;
    public function __construct(ICategoryService $categoryService)
    {
        $this->_categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        // get all Categories
        // // dd($req->user()->attributesToArray()['id']);
        // return $req->user()->attributesToArray()['id'];
        if(isset($req->user()->id))
            $categories = $this->_categoryService->GetAllCategories($req->user()->id);
        else
            $categories = $this->_categoryService->GetAllCategories();
        if(!$categories)
            return response()->json([
                                'message' => 'No Available Categories',
                                'success' => false
                                    ]);
        return response()->json([
                                'data' => $categories,
                                'success' => true
                                    ]);
    }

    // public function GetPAll(){
    //     // get all Published Categories
    //     $categories = $this->_categoryService->GetAllPublishedCategories();
    //     if(!$categories)
    //         return response()->json([
    //                             'message' => 'No Available Categories',
    //                             'success' => false
    //                                 ]);
    //     return response()->json([
    //                             'data' => $categories,
    //                             'success' => true
    //                                 ]);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        // insert A new Category
        return $request->user();
        $res = $this->_categoryService->CreateCategory($request);
        if($res)
            return response()->json([
                                'message' => "Category Created Successfully",
                                'data' => $res,
                                'success' => true]);
        return response()->json([
            'message' => 'Failed To Create Category',
            'success' => false
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $req ,$id )
    {
        // get category By id
        $category = $this->_categoryService->GetCategoryById($id , $req);
        if(!$category)
            return response()->json([
                                'message' => 'Category is Not Found',
                                'success' => false
                                    ] , 404);
        return response()->json([
                                'data' => $category,
                                'success' => true
                                    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request,  $id )
    {
        // update category
        $res = $this->_categoryService->UpdateCategory($request, $id);

        if($res instanceof NotFoundHttpException)
            return response()->json([
        'message' => "Not Found Category",
        'success' => false] , 404);
        //
        if($res)
            return response()->json([
                                'message' => "Category Updated Successfully",
                                'data' => $res,
                                'success' => true]);
        return response()->json([
            'message' => 'Failed To Update Category',
            'success' => false
            ]);
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy( $id , Request $req)
    {
        //
        // delete category
        $res = $this->_categoryService->DeleteCategory($id , $req);

        if($res instanceof NotFoundHttpException)
            return response()->json([
                                'message' => "Not Found Category",
                                'success' => false] , 404);
        //
        if($res)
            return response()->json([
                                'message' => "Category Deleted Successfully",
                                'success' => true]);
        return response()->json([
            'message' => 'Failed To Delete Category',
            'success' => false
        ]);
    }



    public function ShowOrHide($id , Request $req){
        $res = $this->_categoryService->ShowCategory($id , $req);

        // return "true";
        if($res instanceof NotFoundHttpException)
            return response()->json([
                                'message' => "Not Found Category",
                                'success' => false] , 404);
        //
        if($res)
            return response()->json([
                                'message' => 'Category '. ($res->is_published ? 'Showed' : 'hide'). ' Successfully',
                                'success' => true]);
        return response()->json([
            'message' => 'Failed To show or hide Category',
            'success' => false
        ]);
    }
}
