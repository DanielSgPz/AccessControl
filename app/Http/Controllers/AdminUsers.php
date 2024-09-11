<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUsers extends Controller
{
    public function index()
    {

        $departments = Department::all();
        $employees = Employee::with('user', 'department')
            ->whereHas('user', function ($query) {
                $query->where('email', 'not like', 'deleted%');
            })
            ->get();

        // dd($employees);

        return view('dashboard.admin_employees', [
            'departments' => $departments ?  $departments : null,
            'employees' => $employees ?  $employees : null,
        ]);
    }

    /*   public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|in:active,inactive',
            'has_access' => 'required|boolean',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => "employee",
            'active' => $request->status === 'active' ? 1 : 0,

        ]);

        // Create employee
        $employee = Employee::create([
            'user_id' => $user->id,
            'department_id' => $request->department_id,
            'has_access' => $request->has_access,
        ]);

        // Devolver el empleado con la relación de usuario y departamento
        return response()->json([
            'employee' => $employee->load('user', 'department'),
            'message' => 'Employee created successfully',
        ]);
    } */

    public function store(Request $request)
    {
        $request->validate([
            'employee-id' => 'nullable|exists:employees,id', // If exist employee-id edit
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6|confirmed', // Change to nullable in update
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|in:active,inactive',
            'has_access' => 'required|boolean',
        ]);

        if ($request->filled('employee-id')) {
            $employee = Employee::where('id', $request->input('employee-id'))->firstOrFail();
            $employee->update([
                'department_id' => $request->department_id,
                'has_access' => $request->has_access,
            ]);
            $user = User::findOrFail($employee->user->id);
            $user->update([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $request->password ? bcrypt($request->password) : $user->password,
                'active' => $request->status === 'active' ? 1 : 0,
            ]);



            $message = 'Employee updated successfully';
        } else {

            // Create new user
            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => "employee",
                'active' => $request->status === 'active' ? 1 : 0,

            ]);

            // Create new employee
            $employee = Employee::create([
                'user_id' => $user->id,
                'department_id' => $request->department_id,
                'has_access' => $request->has_access,
            ]);
            $message = 'Employee created successfully';
        }

        return response()->json([
            'employee' => $employee->load('user', 'department'),
            'message' => $message,
        ]);
    }


    public function update(Request $request, $id)
    {

        $employee = Employee::with('user', 'department')->find($id);

        if ($employee) {
            return response()->json([
                'employee' => $employee,
            ]);
        } else {
            return response()->json([
                'message' => 'Employee not found',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $user = $employee->user;

        $user->update([
            'email' => 'deleted_' . $user->email,
            'active' => 0
        ]);

        $employee->update([
            'has_access' => 0
        ]);

        return response()->json([
            'message' => 'Employee marked as deleted successfully',
        ]);
    }

    public function bulkUpload(Request $request)
    {
        $employees = $request->input('employees');

        \DB::beginTransaction();

        try {
            foreach ($employees as $employeeData) {


                $status = isset($employeeData['status']) && strtolower($employeeData['status']) === 'active' ? 1 : 0;

                $user = User::create([
                    'name' => $employeeData['name'],
                    'last_name' => $employeeData['last_name'],
                    'email' => $employeeData['email'],
                    'password' => bcrypt($employeeData['password']),
                    'role' => "employee",
                    'active' => $status,
                ]);


                $department = Department::where('name', $employeeData['department'])->first();

                if ($department) {

                    $employee = Employee::create([
                        'user_id' => $user->id,
                        'department_id' => $department->id,
                        'has_access' => strtolower($employeeData['access']) === 'yes' ? 1 : 0,
                    ]);
                } else {

                    \DB::rollBack();
                    return response()->json(['error' => 'Department not found: ' . $employeeData['department']], 400);
                }
            }

            \DB::commit();
            return response()->json(['message' => 'Employees uploaded successfully'], 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Failed to upload employees: ' . $e->getMessage()], 500);
        }
    }
}
