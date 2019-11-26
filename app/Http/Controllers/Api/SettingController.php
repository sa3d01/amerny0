<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SavedPlaces;
use App\Setting;
use App\Social;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function setting(Request $request)
    {
        $setting=Setting::first();
        $socials=[];
        $social=Social::active()->get();
        $row['about']=$setting->about['ar'];
        $row['mobile']=$setting->mobile;
        $row['email']=$setting->email;
        foreach ($social as $item){
            $arr=$item->static_model();
            $socials[]=$arr;
        }
        $row['socials']=$socials;

        return response()->json(['status' => 200, 'data' => $row]);
    }
}
