<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\AppUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use App\Events\ManalNotificationAppUsersEvent;
use App\Notifications\ManalNotificationAppUsers;

class ManualNotification extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $users = AppUsers::whereIn('id', $request->user_ids)->get();

        foreach ($users as $user) {
            ManualNotification::create([
                'user_id' => $user->id,
                'title'=>$request->title,
                'message' => $request->message,
            ]);

        }
        $firebaseToken = AppUsers::whereIn('id', $request->user_ids)->whereNotNull('device_token')->pluck('device_token')->all();
     return   sendFirbase($firebaseToken,$request->title,$request->message);
        // public function sendNotification(Request $request)
        // {
        //     $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        //     $SERVER_API_KEY = 'XXXXXX';

        //     $data = [
        //         "registration_ids" => $firebaseToken,
        //         "notification" => [
        //             "title" => $request->title,
        //             "body" => $request->body,
        //         ]
        //     ];
        //     $dataString = json_encode($data);

        //     $headers = [
        //         'Authorization: key=' . $SERVER_API_KEY,
        //         'Content-Type: application/json',
        //     ];

        //     $ch = curl_init();

        //     curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        //     curl_setopt($ch, CURLOPT_POST, true);
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        //     $response = curl_exec($ch);

        //     dd($response);
        // }



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
