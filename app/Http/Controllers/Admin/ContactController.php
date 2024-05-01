<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return response()->json($contacts);
    }

    public function update(Request $request)
    {
        $contact = Contact::first();
        if ($contact) {
            $contact->update($request->all());
        } else {
            $contact = Contact::create($request->all());
        }
        return response()->json($contact);
    }
}
