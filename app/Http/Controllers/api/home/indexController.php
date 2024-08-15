<?php

namespace App\Http\Controllers\api\home;

use App\Models\ClientModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\api\BaseController;

class indexController extends BaseController
{
    public function index(Request $request)
    {
        $client = $request->user();
        $clients = ClientModel::where("id","!==",$client->id)->paginate(10);

        return parent::success("Kullanıcılar Getirildi.",$clients);
    }
}
