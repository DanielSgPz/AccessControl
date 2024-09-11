<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use App\Models\Employee;
use Illuminate\Http\Request;

//Validate access at room 911, register logs
class Accesscontroller extends Controller
{
    public function accessSuccess()
    {
        return view('success');
    }
    public function accessDenied()
    {
        return view('denied');
    }

    public function validateAccess(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $employeeId = $request->input('id');
        $employee = Employee::find($employeeId);
        if ($employee) {
            if ($employee->has_access) {
                AccessLog::create([
                    'employee_id' => $employeeId,
                    'success' => true,
                    'log' => now(),
                    'detail' => 'Access granted',
                ]);
                return redirect()->route('success')->with('success', 'Access granted for employee ' . $employee->user->name);
            } else {
                AccessLog::create([
                    'employee_id' => $employeeId,
                    'success' => true,
                    'log' => now(),
                    'detail' => 'Employee no granted',
                ]);
                return redirect()->route('denied')->with('error', 'Access denied. Employee not granted.');
            }
        } else {
            AccessLog::create([
                'employee_id' => null,
                'success' => false,
                'log_time' => now(),
                'detail' => 'Attempted access with unregistered ID: ' . $employeeId,
            ]);

            return redirect()->route('denied')->with('error', 'Access denied. Employee not registered.');
        }
    }
}
