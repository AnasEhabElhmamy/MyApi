<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\DebitController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
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

Route::post('storeUser',[ApiController::class,'store']);


Route::post('login',[ApiController::class,'login']);
Route::group(['middleware'=>'auth:api'],function(){

 Route::post('UpdateUser/{id}',[ApiController::class,'update']);

Route::get('IndexPro',[ProductController::class,'index']);
Route::get('ShowPro/{id}',[ProductController::class,'show']);
Route::post('StorePro',[ProductController::class,'store']);
Route::post('UpdatePro/{id}',[ProductController::class,'update']);
Route::delete('DestroyPro/{id}',[ProductController::class,'destroy']);
Route::get('FilterPro',[ProductController::class,'FilterProducts']);

Route::post('StoreDebits',[DebitController::class,'store']);
Route::get('IndexDebits',[DebitController::class,'index']);
Route::get('ShowDebit/{id}',[DebitController::class,'show']);
Route::post('UpdateDebit/{id}',[DebitController::class,'update']);
Route::delete('DestroyDebit/{id}',[DebitController::class,'destroy']);
Route::get('FilterDebit',[DebitController::class,'FilterDebit']);

Route::post('StoreDirector',[DirectorController::class,'store']);
Route::get('ShowDirector/{id}',[DirectorController::class,'show']);
Route::get('IndexDirector',[DirectorController::class,'index']);
Route::post('UpdateDirector/{id}',[DirectorController::class,'update']);
Route::delete('DestroyDirector/{id}',[DirectorController::class,'destroy']);
Route::get('GetDirectorEmployee',[DirectorController::class,'DirectorEmployee']);
Route::get('FilterDirector',[DirectorController::class,'FilterDirector']);

Route::post('StoreEmployee',[EmployeeController::class,'store']);
Route::get('ShowEmployee/{id}',[EmployeeController::class,'show']);
Route::get('IndexEmployee',[EmployeeController::class,'index']);
Route::post('UpdateEmployee/{id}',[EmployeeController::class,'update']);
Route::delete('DestroyEmployee/{id}',[EmployeeController::class,'destroy']);
Route::get('FilterEmployee',[EmployeeController::class,'FilterEmployee']);


});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
