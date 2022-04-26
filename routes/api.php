<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apicontroller;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get("list",[apicontroller::class,'list']);
Route::put("update",[apicontroller::class,'update']);
Route::delete("delete/{id}",[apicontroller::class,'delete']);
Route::get("search/{id}",[apicontroller::class,'search']);
