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

class GeneralController extends Controller
{
    public function getAllServices()
    {
        $services = Service::all();
        return response()->json(['services' => $services], 200);
    }
    public function getAllTerm()
    {
        $term = Term::all();
        return response()->json(['term' => $term], 200);
    }
    public function getAllprivacy()
    {
        $privacy = Privacy::all();
        return response()->json(['privacy' => $privacy], 200);
    }
    public function getAllsetting()
    {
        $settings = Setting::pluck('value', 'key')
        ->toArray();
        $image = asset('uploads/settings/' .  $settings['site_logo']);
        $settings['site_logo'] =    $image;
        return  $settings;
    }



    public function getContactUs()
    {
        $contactUs = Contact::all();
        return response()->json(['contact_us' => $contactUs], 200);
    }

    public function getAboutUs()
    {
        $aboutUs = AboutUs::all();
        return response()->json(['about_us' => $aboutUs], 200);
    }
    public function getQuestion()
    {
        $question = Question::all();
        return response()->json(['Question' => $question], 200);
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
