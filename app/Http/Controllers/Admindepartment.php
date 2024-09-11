<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class Admindepartment extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
        ]);

        $department = Department::create([
            'name' => $request->department_name,
        ]);

        return response()->json([
            'message' => 'Department created successfully',
            'department' => $department,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:255',
        ]);

        $department = Department::findOrFail($id);
        $department->name = $validated['department_name'];
        $department->save();

        return response()->json([
            'message' => 'Department updated successfully.',
            'department' => $department,
        ]);
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return response()->json([
            'message' => 'Department deleted successfully',
        ]);
    }
}
