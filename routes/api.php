<?php
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderProductsController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


// Auth Routes
Route::post('/register' , [AuthApiController::class , 'register']);
Route::post('/login' , [AuthApiController::class , 'login']);
Route::post('/checkToken' , [AuthApiController::class , 'checkToken']);
//product Routes
Route::get('/products/latest' , [ProductController::class , 'GetLatestPros']);
Route::apiResource('/products' , ProductController::class)->only(['show' , 'index']);
Route::get('/products/category/{cat_id}' , [ProductController::class , 'GetProductsByCat']);


// Category Routes
Route::apiResource('/categories' , CategoryController::class)->only(['show' , 'index']);



// Admin Routes
Route::middleware(['auth:sanctum'  , 'role:admin'])->group(function(){
    Route::delete('/delete/{id}', [AuthApiController::class , 'softDelete']);
    Route::PUT('/restore/{id}', [AuthApiController::class , 'restoreUser']);

    Route::put('/products/publish/{id}' , [ProductController::class , 'publishProduct']);

    Route::apiResource('/admin/categories' , CategoryController::class);
    Route::put('/categories/SorHCat/{id}' , [CategoryController::class , 'ShowOrHide']);
});
// End
// User Routes
Route::middleware(['auth:sanctum' , 'role:user'])->group(function(){
    Route::apiResource('/user/cart' , CartController::class);
    Route::delete('/user/cart/item/{id}' , [CartController::class , 'decrement']);
    Route::post('/user/cart/checkout' , [CartController::class ,'checkout']);
});
// End


// Vendor Routes
Route::middleware(['auth:sanctum'  , 'role:vendor'])->group(function(){
    Route::apiResource('/products' , ProductController::class)->only(['store' , 'update' , 'destroy']);

    Route::apiResource('/orderProds' , OrderProductsController::class);
});
//End


// Public Routes
Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('/products' , ProductController::class)->only(['show' , 'index']);
    Route::get('/profile', [AuthApiController::class , 'getProfile']);
});
//End

?>
