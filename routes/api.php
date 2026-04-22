<?php
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderProductsController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


// Auth Routes
    Route::apiResource('/products' , ProductController::class)->only(['show' , 'index']);

Route::post('/register' , [AuthApiController::class , 'register']);
Route::post('/login' , [AuthApiController::class , 'login']);
Route::post('/checkToken' , [AuthApiController::class , 'checkToken']);

// End
Route::middleware(['auth:sanctum'  , 'role:admin'])->group(function(){
    Route::get('/profile', [AuthApiController::class , 'getProfile']);
    Route::delete('/delete/{id}', [AuthApiController::class , 'softDelete']);
    Route::PUT('/restore/{id}', [AuthApiController::class , 'restoreUser']);

    Route::apiResource('/products' , ProductController::class)->only('index');
    Route::put('products/publish/{id}' , [ProductController::class , 'publishProduct']);

    Route::apiResource('/categories' , CategoryController::class);
    Route::put('/categories/SorHCat/{id}' , [CategoryController::class , 'ShowOrHide']);
});

// User Routes
Route::middleware(['auth:sanctum' , 'role:user'])->group(function(){
    Route::apiResource('/categories' , CategoryController::class)->only(['index' , 'show']);

    Route::get('/products/latest' , [ProductController::class , 'GetLatestPros']);
    Route::get('/products/category/{cat_id}' , [ProductController::class , 'GetProductsByCat']);
    Route::apiResource('/products' , ProductController::class)->except(['store' , 'update' , 'destroy']);

    Route::get('user/profile', [AuthApiController::class , 'getProfile']);
    Route::apiResource('user/cart' , CartController::class);
    Route::delete('user/cart/item/{id}' , [CartController::class , 'decrement']);
    Route::post('user/cart/checkout' , [CartController::class ,'checkout']);
});
// End


// Vendor Routes
Route::middleware(['auth:sanctum'  , 'role:vendor'])->group(function(){
    Route::apiResource('/products' , ProductController::class);
    Route::apiResource('/orderProds' , OrderProductsController::class);

    Route::get('vendor/profile', [AuthApiController::class , 'getProfile']);
});
//End


// admin Routes

//End

// Public Routes
// Route::middleware('auth:sanctum')->group(function(){

//     });

    Route::apiResource('/categories' , CategoryController::class)->only(['show' , 'index']);
    Route::get('/products/latest' , [ProductController::class , 'GetLatestPros']);
    Route::get('/products/category/{cat_id}' , [ProductController::class , 'GetProductsByCat']);

//End

?>
