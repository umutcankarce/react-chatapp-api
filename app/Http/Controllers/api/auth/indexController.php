<?php

namespace App\Http\Controllers\api\auth;

use App\Models\ClientModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\api\BaseController;
use App\Http\Requests\api\auth\LoginRequest;
use App\Http\Requests\api\auth\RegisterRequest;

class indexController extends BaseController
{
    public function login(LoginRequest $request)
    {
        $data = $request->except("_token");

        $client = ClientModel::where("email",$data["email"])->first();

        if($client && Hash::check($data["password"],$client->password)){

            $token = $client->createToken("chat")->accessToken;

            return parent::success("Sisteme Giriş Yapılıyor.",[
                "id"    => $client->id,
                "name"  => $client->name,
                "email" => $client->email,
                "token_type"   => "Bearer",
                "access_token" => $token
            ],200);


        }else {
            return parent::error("Kullanıcı Bilgileri Hatalı!",[],401);
        }
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->except("_token","password_confirmation");

        $data["password"] = Hash::make($data["password"]);

        $create = ClientModel::create($data);

        if($create){
            return parent::success("Kullanıcı Kayıt Eklendi.",[$create],201);
        }else {
            return parent::error("Kullanıcı Kayıt İşleminde Hata Oluştu.",[]);
        }
    }

    public function profile(Request $request){
        $client = $request->user();
        return parent::success("Kullanıcı Bilgileri Getirildi.",[
            "user" => $client
        ],200);
    }

    public function check(Request $request)
    {
        $client = $request->user();
        if($client){
            $token = $client->createToken("chat")->accessToken;
            return response()->json([
                "success"    => true,
                "isLoggedIn" => true,
                "data" => [
                    "id"    => $client->id,
                    "name"  => $client->name,
                    "email" => $client->email,
                    "token_type"   => "Bearer",
                    "access_token" => $token
                ]
            ]);
        }else {
            return response()->json([
                "success"    => false,
                "isLoggedIn" => false,
            ]);
        }
    }

    public function logout(Request $request)
    {
        $client = $request->user();
        $token = $client->token();
        $token->revoke();
        return parent::success("Sistemden Çıkış Yapıldı.");
    }
}
