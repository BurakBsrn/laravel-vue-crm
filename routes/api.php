<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\DashboardController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['guest']], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    Route::get('refresh', [AuthController::class, 'refresh']);

    Route::get('dashboard', DashboardController::class);
    Route::apiResource('categories', CategoryController::class);
});


/** ANASAYFA KISMI **/
Route::group(['prefix'=>'home','namespace'=>'home','as'=>'product.','middleware'=>'JWT'],function (){
    Route::get('',[\App\Http\Controllers\api\home\indexController::class,'index']);
});

/** URUNLER KISMI **/
Route::group(['prefix'=>'product','namespace'=>'product','as'=>'product.','middleware'=>'JWT'],function (){
    Route::get('',[\App\Http\Controllers\api\product\indexController::class,'index']);
    Route::get('search',[\App\Http\Controllers\api\product\indexController::class,'search']);
    Route::get('create',[\App\Http\Controllers\api\product\indexController::class,'create']);
    Route::post('store',[\App\Http\Controllers\api\product\indexController::class,'store']);
    Route::group(['prefix'=>'{item}'],function (){
        Route::get('edit',[\App\Http\Controllers\api\product\indexController::class,'edit']);
        Route::patch('update',[\App\Http\Controllers\api\product\indexController::class,'update']);
        Route::delete('delete',[\App\Http\Controllers\api\product\indexController::class,'delete']);
    });
});

/** KATEGORILER KISMI **/
Route::group(['prefix'=>'category','namespace'=>'category','as'=>'category.','middleware'=>'JWT'],function (){
    Route::get('',[\App\Http\Controllers\api\category\indexController::class,'index']);
    Route::get('search',[\App\Http\Controllers\api\category\indexController::class,'search']);
    Route::post('store',[\App\Http\Controllers\api\category\indexController::class,'store']);
    Route::group(['prefix'=>'{item}'],function (){
        Route::get('edit',[\App\Http\Controllers\api\category\indexController::class,'edit']);
        Route::patch('update',[\App\Http\Controllers\api\category\indexController::class,'update']);
        Route::delete('delete',[\App\Http\Controllers\api\category\indexController::class,'delete']);
    });
});

/** MUSTERILER KISMI **/
Route::group(['prefix'=>'customer','namespace'=>'customer','as'=>'customer.','middleware'=>'JWT'],function (){
    Route::get('',[\App\Http\Controllers\api\customer\indexController::class,'index']);
    Route::get('search',[\App\Http\Controllers\api\customer\indexController::class,'search']);
    Route::post('store',[\App\Http\Controllers\api\customer\indexController::class,'store']);
    Route::group(['prefix'=>'{item}'],function (){
        Route::get('edit',[\App\Http\Controllers\api\customer\indexController::class,'edit']);
        Route::patch('update',[\App\Http\Controllers\api\customer\indexController::class,'update']);
        Route::delete('delete',[\App\Http\Controllers\api\customer\indexController::class,'delete']);
    });
});

/** STOKLAR KISMI **/
Route::group(['prefix'=>'stock','namespace'=>'stock','as'=>'stock.','middleware'=>'JWT'],function (){
    Route::get('',[\App\Http\Controllers\api\stock\indexController::class,'index']);
    Route::get('search',[\App\Http\Controllers\api\stock\indexController::class,'search']);
    Route::get('create',[\App\Http\Controllers\api\stock\indexController::class,'create']);
    Route::post('store',[\App\Http\Controllers\api\stock\indexController::class,'store']);
    Route::group(['prefix'=>'{item}'],function (){
        Route::get('edit',[\App\Http\Controllers\api\stock\indexController::class,'edit']);
        Route::patch('update',[\App\Http\Controllers\api\stock\indexController::class,'update']);
        Route::delete('delete',[\App\Http\Controllers\api\stock\indexController::class,'delete']);
    });
});

/** PROFILE KISMI **/
Route::group(['prefix'=>'profile','namespace'=>'profile','as'=>'profile.','middleware'=>'JWT'],function (){
    Route::group(['prefix'=>"{item}"],function (){
        Route::patch('update',[\App\Http\Controllers\api\profile\indexController::class,'update']);
    });
});
