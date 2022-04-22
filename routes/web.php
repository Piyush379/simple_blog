<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\maincontroller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// register
Route::view("/register","register");
Route::post("/register",[maincontroller::class,'register']);


//login and check
Route::view("/login",'login');
Route::post("/login",[maincontroller::class,'logincheck']);


Route::group(['middleware'=>'admin_auth'],function(){
    Route::view("/dashboard","dashboard");
    Route::view("/addblog","addblog");
    Route::post("/addblog",[maincontroller::class,'addblog']);

    // showblog
    Route::get('/dashboard',[maincontroller::class,'showblogs']);

    // delete blog
    Route::get('/delete/{id}',[maincontroller::class,'delete']);

    // update blog
    Route::get('/update/{id}',[maincontroller::class,'update']);

    Route::post('/update/updatenew',[maincontroller::class,'updatesubmit']);

    // profile
    Route::get('/profile/{email}',[maincontroller::class,'profile']);


    Route::get('/profile/editprofile/{email}',[maincontroller::class,'editprofile']);
    Route::post('/profile/editprofile/saveedit',[maincontroller::class,'saveedit']);


    Route::get('/profile/editprofile/deletepic/{email}',[maincontroller::class,'deletepic']);

    // Route::view('profile/editprofile/changepic','changepic');
    Route::get('/profile/editprofile/changepic/{email}',[maincontroller::class,'changepic']);
    Route::post('/profile/editprofile/changepic/{email}',[maincontroller::class,'changepicsave']);


});

// logout
Route::get('/logout',function(){
    if(session()->has("ADMIN_LOGIN")){
        session()->pull("ADMIN_LOGIN");
        session()->pull("ADMIN_EMAIL");
        session()->pull("key");
        // session()->save();
    }
    return redirect("login");
});

