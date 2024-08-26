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
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'key' => 'required|string|max:255',
            'price' => 'nullable|string|max:255',
            'option_type_id' => 'required|exists:option_types,id',
        ]);

        // محاولة العثور على السجل الموجود بناءً على `key` و `option_type_id`
        $option = Options::where('key', $validated['key'])
            ->where('option_type_id', $validated['option_type_id'])
            ->first();

        if ($option) {
            // إذا كان السجل موجودًا، قم بتحديثه
            $option->update($validated);
            $status = 200; // حالة نجاح التحديث
        } else {
            // إذا لم يكن موجودًا، قم بإنشاء سجل جديد
            $option = Options::create($validated);
            $status = 201; // حالة نجاح الإنشاء
        }

        // إعادة السجل في الاستجابة مع حالة النجاح المناسبة
        return response()->json(['data'=>$option], 200);

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
            'key' => 'required|string|max:255',
            'price' => 'nullable|string|max:255',
            'option_type_id' => 'required|exists:option_types,id',
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
