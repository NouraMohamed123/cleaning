<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PaymentGetway;
use App\Http\Controllers\Controller;
class PaymentGatewayController extends Controller
{
    public function index()
    {
        $data['tammara'] = PaymentGetway::where([
            ['keyword', 'Tammara'],
        ])->first();

        $data['tabby'] = PaymentGetway::where([
            ['keyword', 'Tabby'],
        ])->first();
        if ( $data['tammara']) {
            $information = json_decode( $data['tammara']->information, true);

             $data['tammara']->information = $information;
             $data['tammara']->image = asset('uploads/tammara/' .  $data['tammara']->image) ;
        }
        if ($data['tabby']) {
            $information = json_decode($data['tabby']->information, true);
            $data['tabby']->information = $information;
            $data['tabby']->image = asset('uploads/tabby/' . $data['tabby']->image) ;
        }
        return response()->json([
            "isSuccess" => true,
            'data' => $data
        ], 200);
    }


    public function TammaraUpdate(Request $request)
    {
        $tammara =PaymentGetway::where([
            ['keyword', 'Tammara'],
        ])->first();
      //  dd($myfatoorah);
        $tammara->status = $request->status;
        $information = [];
        $information['api_token'] = $request->api_token;
        $tammara->information = json_encode($information);
        if (request()->has('image') &&  request('image') != '') {
            $avatar = request()->file('image');
            if ($avatar->isValid()) {
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatarPath = public_path('/uploads/tammara');
                $avatar->move($avatarPath, $avatarName);
                $image  = $avatarName;
            }
        } else {
            $image = $tammara->image;
        }
        $tammara->image = $image;
        $tammara->save();

        return response()->json([
            "isSuccess" => true,
            'data' => $tammara
        ], 200);
    }

    public function TabbyUpdate(Request $request)
    {
        $tabby = PaymentGetway::where([
            ['keyword', 'Tabby'],
        ])->first();
      //  dd($myfatoorah);
        $tabby->status = $request->status;
        $information = [];
        $information['api_token'] = $request->api_token;
        $tabby->information = json_encode($information);
        if (request()->has('image') &&  request('image') != '') {
            $avatar = request()->file('image');
            if ($avatar->isValid()) {
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatarPath = public_path('/uploads/tabby');
                $avatar->move($avatarPath, $avatarName);
                $image  = $avatarName;
            }
        } else {
            $image = $tabby->image;
        }
        $tabby->image = $image;
        $tabby->save();

        return response()->json([
            "isSuccess" => true,
            'data' => $tabby
        ], 200);
    }
}
