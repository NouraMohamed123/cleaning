<?php

namespace App\Http\Controllers\Admin;

use App\Models\OptionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionTypeController extends Controller
{
    public function index()
    {
        $optionTypes = OptionType::with('service')->get();
        return response()->json($optionTypes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
        ]);

        $optionType = OptionType::create($validated);

        return response()->json($optionType->load('service'), 201);
    }

    public function show($id)
    {
        $optionType = OptionType::with('service')->findOrFail($id);
        return response()->json($optionType);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
        ]);

        $optionType = OptionType::findOrFail($id);
        $optionType->update($validated);

        return response()->json($optionType->load('service'));
    }

    public function destroy($id)
    {
        $optionType = OptionType::findOrFail($id);
        $optionType->delete();
        return response()->json(null, 204);
    }
}
