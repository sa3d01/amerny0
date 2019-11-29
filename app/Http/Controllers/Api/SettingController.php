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
        $row['about']=$setting->about['ar'];
        $row['mobile']=$setting->mobile;
        $row['email']=$setting->email;
        $row['facebook']=Social::where('name','facebook')->value('link');
        $row['twitter']=Social::where('name','twitter')->value('link');
        $row['insta']=Social::where('name','insta')->value('link');
        return response()->json(['status' => 200, 'data' => $row]);
    }
}
