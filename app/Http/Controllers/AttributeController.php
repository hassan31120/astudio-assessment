<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        return Attribute::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:attributes',
            'type' => 'required|in:text,date,number,select',
        ]);

        return Attribute::create($request->all());
    }

    public function show($id)
    {
        $attribute = Attribute::findOrFail($id);
        return $attribute;
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);
        $request->validate([
            'name' => 'sometimes|string|unique:attributes,name,' . $attribute->id,
            'type' => 'sometimes|in:text,date,number,select',
        ]);

        $attribute->update($request->all());
        return $attribute;
    }

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
        return response()->json(['message' => 'Attribute deleted']);
    }
}

