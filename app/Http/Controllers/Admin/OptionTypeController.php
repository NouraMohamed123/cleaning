<?php

namespace App\Http\Controllers\Admin;

use App\Models\OptionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionTypeController extends Controller
{
    public function index()
    {
        $optionTypes = OptionType::all();
        return response()->json($optionTypes);
    }

    public function create()
    {
        // Typically not used for API, form handled on frontend
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $optionType = OptionType::create($validated);
        return response()->json($optionType, 201);
    }

    public function show($id)
    {
        $optionType = OptionType::findOrFail($id);
        return response()->json($optionType);
    }

    public function edit($id)
    {
        // Typically not used for API, form handled on frontend
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $optionType = OptionType::findOrFail($id);
        $optionType->update($validated);
        return response()->json($optionType);
    }

    public function destroy($id)
    {
        $optionType = OptionType::findOrFail($id);
        $optionType->delete();
        return response()->json(null, 204);
    }
}
