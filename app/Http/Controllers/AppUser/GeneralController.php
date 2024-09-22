<?php

namespace App\Http\Controllers\AppUser;

use App\Models\Area;
use App\Models\City;
use App\Models\Term;
use App\Models\AboutUs;
use App\Models\Contact;
use App\Models\Privacy;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\ServiceResource;
use App\Models\CustomeService;
use App\Models\Offer;

class GeneralController extends Controller
{
    public function getAllServices()
    {
        $services = Service::all();
        return response()->json(['data' => ServiceResource::collection($services)], 200);
    }
    public function getOffers()
    {
        $offers = Offer::first();
        return response()->json(['data' => $offers], 200);
    }
    public function getAllTerm()
    {
        $term = Term::all();
        return response()->json(['data' => $term], 200);
    }
    public function getAllprivacy()
    {
        $privacy = Privacy::all();
        return response()->json(['data' => $privacy], 200);
    }
    public function getAllsetting()
    {
        $settings = Setting::pluck('value', 'key')
        ->toArray();
        $image = asset('uploads/settings/' .  $settings['site_logo']);
        $settings['site_logo'] =    $image;
        return  $settings;
    }

    public function customer_service()
    {
        $customers = CustomeService::all();
        return  $customers;
    }

    public function getContactUs()
    {
        $contactUs = Contact::all();
        return response()->json(['data' => $contactUs], 200);
    }

    public function getAboutUs()
    {
        $aboutUs = AboutUs::all();
        return response()->json(['data' => $aboutUs], 200);
    }
    public function getQuestion()
    {
        $question = Question::all();
        return response()->json(['data' => $question], 200);
    }
    public function cities()
    {
        $terms = City::get();
        return CityResource::collection($terms);
    }

    public function cityArea($id){
        $areas =  Area::where('city_id',$id)->get();
        return AreaResource::collection($areas);
    }

}
