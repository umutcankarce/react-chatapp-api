<?php

use App\Http\Controllers\api\auth\indexController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "client","as" => "client."],function(){
    Route::post('/login',[indexController::class,'login'])->name("login");
    Route::post('/register',[indexController::class,'register'])->name("register");

    Route::group(["middleware"=>"auth:api_client"],function(){
        Route::get('/check',[indexController::class,'check'])->name("check");
        Route::get('/profile',[indexController::class,'profile'])->name("profile");
        Route::get('/logout',[indexController::class,'logout'])->name("logout");
    });
});

Route::group(["prefix" => "home","as" => "home.","middleware"=>"auth:api_client"],function(){
    Route::get('/',[App\Http\Controllers\api\home\indexController::class,'index'])->name("index");
});
