<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->has('filters')) {
            foreach ($request->filters as $key => $value) {
                if (in_array($key, ['name', 'status'])) {
                    $query->where($key, 'LIKE', "%$value%");
                } else {
                    $query->whereHas('attributes', function ($q) use ($key, $value) {
                        $q->whereHas('attribute', function ($attr) use ($key) {
                            $attr->where('name', $key);
                        })->where('value', 'LIKE', "%$value%");
                    });
                }
            }
        }

        $projects = $query->with('attributes.attribute')->get();

        return response()->json([
            'success' => true,
            'data' => $projects,
            'message' => 'Projects retrieved successfully',
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'status' => 'required|in:active,inactive,completed',
        ]);

        $project = Project::create($validatedData);

        return response()->json([
            'success' => true,
            'data' => $project,
            'message' => 'Project created successfully',
        ], 201);
    }

    public function show($id)
    {
        $project = Project::with('users', 'attributes')->find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $project,
            'message' => 'Project retrieved successfully',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found',
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string',
            'status' => 'sometimes|in:active,inactive,completed',
        ]);

        $project->update($validatedData);

        return response()->json([
            'success' => true,
            'data' => $project,
            'message' => 'Project updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found',
            ], 404);
        }

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully',
        ], 200);
    }
}
