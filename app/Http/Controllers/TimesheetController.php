<?php
namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function index()
    {
        return Timesheet::with('user', 'project')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'task_name' => 'required|string',
            'date' => 'required|date',
            'hours' => 'required|integer|min:1',
        ]);

        return Timesheet::create($request->all());
    }

    public function show($id)
    {
        $timesheet = Timesheet::findOrFail($id);
        return $timesheet->load('user', 'project');
    }

    public function update(Request $request, $id)
    {
        $timesheet = Timesheet::findOrFail($id);
        $request->validate([
            'task_name' => 'sometimes|string',
            'date' => 'sometimes|date',
            'hours' => 'sometimes|integer|min:1',
        ]);

        $timesheet->update($request->all());

        return $timesheet;
    }

    public function destroy($id)
    {
        $timesheet = Timesheet::findOrFail($id);
        $timesheet->delete();
        return response()->json(['message' => 'Timesheet deleted']);
    }
}

