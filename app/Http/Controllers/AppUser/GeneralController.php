<?php

namespace App\Http\Controllers\AppUser;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Contact;
use App\Models\Privacy;
use App\Models\Question;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Term;
use Illuminate\Http\Request;

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
        $setting = Setting::all();
        return response()->json(['setting' => $setting], 200);
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
}
