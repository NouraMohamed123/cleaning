<?php

namespace App\Http\Controllers\Admin;

use App\Models\Options;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    public function index()
    {
        $options = Options::all();
        return response()->json($options);
    }

    public function create()
    {
        // Typically not used for API, form handled on frontend
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'option_type_id' => 'required|exists:option_types,id',
            'value' => 'required|string|max:255',
        ]);

        $option = Options::create($validated);
        return response()->json($option, 201);
    }

    public function show($id)
    {
        $option = Options::findOrFail($id);
        return response()->json($option);
    }

    public function edit($id)
    {
        // Typically not used for API, form handled on frontend
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'option_type_id' => 'required|exists:option_types,id',
            'value' => 'required|string|max:255',
        ]);

        $option = Options::findOrFail($id);
        $option->update($validated);
        return response()->json($option);
    }

    public function destroy($id)
    {
        $option = Options::findOrFail($id);
        $option->delete();
        return response()->json(null, 204);
    }
}
