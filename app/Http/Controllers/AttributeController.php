<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::all();
        return response()->json([
            'success' => true,
            'data' => $attributes,
            'message' => 'Attributes fetched successfully',
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:attributes,name',
            'type' => 'required|in:text,date,number,select',
        ]);

        $attribute = Attribute::create($validatedData);

        return response()->json([
            'success' => true,
            'data' => $attribute,
            'message' => 'Attribute created successfully',
        ], 201);
    }

    public function show($id)
    {
        $attribute = Attribute::find($id);

        if (!$attribute) {
            return response()->json([
                'success' => false,
                'message' => 'Attribute not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $attribute,
            'message' => 'Attribute fetched successfully',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::find($id);

        if (!$attribute) {
            return response()->json([
                'success' => false,
                'message' => 'Attribute not found',
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|unique:attributes,name,' . $attribute->id,
            'type' => 'sometimes|in:text,date,number,select',
        ]);

        $attribute->update($validatedData);

        return response()->json([
            'success' => true,
            'data' => $attribute,
            'message' => 'Attribute updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $attribute = Attribute::find($id);

        if (!$attribute) {
            return response()->json([
                'success' => false,
                'message' => 'Attribute not found',
            ], 404);
        }

        $attribute->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attribute deleted successfully',
        ], 200);
    }
}
