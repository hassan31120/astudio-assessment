<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'project_id' => 'required|exists:projects,id',
            'value' => 'required|string',
        ]);

        $attributeValue = AttributeValue::create($validatedData);

        return response()->json([
            'success' => true,
            'data' => $attributeValue,
            'message' => 'Attribute Value created successfully',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $attributeValue = AttributeValue::find($id);

        if (!$attributeValue) {
            return response()->json([
                'success' => false,
                'message' => 'Attribute Value not found',
            ], 404);
        }

        $validatedData = $request->validate([
            'value' => 'required|string',
        ]);

        $attributeValue->update($validatedData);

        return response()->json([
            'success' => true,
            'data' => $attributeValue,
            'message' => 'Attribute Value updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $attributeValue = AttributeValue::find($id);

        if (!$attributeValue) {
            return response()->json([
                'success' => false,
                'message' => 'Attribute Value not found',
            ], 404);
        }

        $attributeValue->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attribute Value deleted successfully',
        ], 200);
    }
}
