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

        return $query->with('attributes.attribute')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'status' => 'required|in:active,inactive,completed',
        ]);

        return Project::create($request->all());
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return $project->load('users', 'attributes');
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $request->validate([
            'name' => 'sometimes|string',
            'status' => 'sometimes|in:active,inactive,completed',
        ]);

        $project->update($request->all());

        return $project;
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return response()->json(['message' => 'Project deleted']);
    }
}
