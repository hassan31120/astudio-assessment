<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function index()
    {
        $timesheets = Timesheet::with('user', 'project')->get();

        return response()->json([
            'success' => true,
            'data' => $timesheets,
            'message' => 'Timesheets retrieved successfully',
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'task_name' => 'required|string',
            'date' => 'required|date',
            'hours' => 'required|integer|min:1',
        ]);

        $timesheet = Timesheet::create($validatedData);

        return response()->json([
            'success' => true,
            'data' => $timesheet,
            'message' => 'Timesheet created successfully',
        ], 201);
    }

    public function show($id)
    {
        $timesheet = Timesheet::with('user', 'project')->find($id);

        if (!$timesheet) {
            return response()->json([
                'success' => false,
                'message' => 'Timesheet not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $timesheet,
            'message' => 'Timesheet retrieved successfully',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $timesheet = Timesheet::find($id);

        if (!$timesheet) {
            return response()->json([
                'success' => false,
                'message' => 'Timesheet not found',
            ], 404);
        }

        $validatedData = $request->validate([
            'task_name' => 'sometimes|string',
            'date' => 'sometimes|date',
            'hours' => 'sometimes|integer|min:1',
        ]);

        $timesheet->update($validatedData);

        return response()->json([
            'success' => true,
            'data' => $timesheet,
            'message' => 'Timesheet updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $timesheet = Timesheet::find($id);

        if (!$timesheet) {
            return response()->json([
                'success' => false,
                'message' => 'Timesheet not found',
            ], 404);
        }

        $timesheet->delete();

        return response()->json([
            'success' => true,
            'message' => 'Timesheet deleted successfully',
        ], 200);
    }
}
