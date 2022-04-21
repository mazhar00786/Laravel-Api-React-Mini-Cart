<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//API Route
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\FrontendController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register', [RegisterController::class, 'register']);

Route::post('login', [LoginController::class, 'login']);

Route::get('getCategory',  [FrontendController::class, 'category']);
Route::get('fetchProducts/{slug}', [FrontendController::class, 'product']);
Route::get('productDetail/{category_slug}/{product_slug}', [FrontendController::class, 'productDetails']);

Route::post('add-to-cart', [CartController::class, 'addToCart']);

Route::get('cart', [CartController::class, 'getCart']);

Route::put('update-cartQuantity/{cart_id}/{scope}', [CartController::class, 'updateCartQuantity']);

Route::delete('delete-cart/{id}', [CartController::class, 'destroy']);

Route::post('place-order', [CheckoutController::class, 'placeOrder']);

Route::post('validate-order', [CheckoutController::class, 'validateOrder']);

Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group(function () {
    
    Route::get('/checkAuthenticated', function () {
        return response()->json(['status' => 200, 'message' => 'You are Authenticated'], 200);
    });

    Route::get('categories', [CategoryController::class, 'index']);

    Route::post('store-category', [CategoryController::class, 'store']);

    Route::get('edit-category/{id}', [CategoryController::class, 'edit']);
    
    Route::put('update-category/{any}', [CategoryController::class, 'update']);

    Route::delete('delete-category/{id}', [CategoryController::class, 'destroy']);

    //
    Route::get('all-category', [CategoryController::class, 'allCategory']);

    //All Product
    Route::post('add-product', [ProductController::class, 'store']);

    Route::get('products', [ProductController::class, 'index']);

    Route::get('edit-product/{id}', [ProductController::class, 'edit']);

    Route::post('update-product/{id}', [ProductController::class, 'update']);

    Route::delete('delete-product/{id}',[ProductController::class, 'destroy']);

    //Manage Orders By Admin
    Route::get('admin/orders', [OrderController::class, 'index']);

});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

//
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
