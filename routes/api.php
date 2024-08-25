<?php

use App\Http\Controllers\api\auth\indexController as AuthController;
use App\Http\Controllers\api\home\indexController as HomeController;
use App\Http\Controllers\api\message\indexController as MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "client","as" => "client."],function(){
    Route::post('/login',[AuthController::class,'login'])->name("login");
    Route::post('/register',[AuthController::class,'register'])->name("register");

    Route::group(["middleware"=>"auth:api_client"],function(){
        Route::get('/check',[AuthController::class,'check'])->name("check");
        Route::get('/profile',[AuthController::class,'profile'])->name("profile");
        Route::get('/logout',[AuthController::class,'logout'])->name("logout");
    });
});

Route::group(["prefix" => "home","as" => "home.","middleware"=>"auth:api_client"],function(){
    Route::get('/',[HomeController::class,'index'])->name("index");
});

Route::group(["prefix" => "message","as" => "message.","middleware"=>"auth:api_client"],function(){
    Route::post('/search-receiver',[MessageController::class,'search_receiver'])->name('search_receiver');
    Route::post('/get-messages',[MessageController::class,'get_messages'])->name('get_messages');
    Route::post('/send-message',[MessageController::class,'send_message'])->name('send_message');
    Route::post('/update-read',[MessageController::class,'update_read'])->name('update_read');
});
