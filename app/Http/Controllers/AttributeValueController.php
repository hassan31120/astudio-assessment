<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'project_id' => 'required|exists:projects,id',
            'value' => 'required|string',
        ]);

        return AttributeValue::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        $request->validate([
            'value' => 'required|string',
        ]);

        $attributeValue->update($request->all());
        return $attributeValue;
    }

    public function destroy($id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        $attributeValue->delete();
        return response()->json(['message' => 'Attribute Value deleted']);
    }
}

