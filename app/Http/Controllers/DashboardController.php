<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\PDF as DomPDFPDF;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Filter params
        $searchTerm = $request->input('search');
        $departmentId = $request->input('department');
        $initialDate = $request->input('initial_date');
        $finalDate = $request->input('final_date');

        // Query
        $query = AccessLog::query()
            ->select('employee_id')
            ->with(['employee.user', 'employee.department'])
            ->selectRaw('count(*) as total_accesses')
            ->groupBy('employee_id');

        // If search term exists, filter by employee ID, name, or last name
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('employee_id', $searchTerm)  // Search by employee ID
                    ->orWhereHas('employee.user', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', "%$searchTerm%")  // Search by name
                            ->orWhere('last_name', 'like', "%$searchTerm%");  // Search by last name
                    });
            });
        }

        //Filter by departmen if exist
        if ($departmentId) {
            $query->whereHas('employee', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            });
        }

        //Filter by date if exist
        if ($initialDate && $finalDate) {
            $query->whereBetween('log', [$initialDate, $finalDate]);
        }

        $access = $query->get();



        $departments = Department::all();
        return view('dashboard.dashboard', [
            'user' => auth()->user(),
            'access' => $access,
            'departments' => $departments
        ]);
    }

    public function employeeLogs(Request $request)
    {
        $employeeId = $request->input('employee_id');

        $accesslog = AccessLog::select('employee_id', 'success', 'detail', 'log')
            ->where('employee_id', $employeeId)
            ->with(['employee.user', 'employee.department'])
            ->get();

        if ($accesslog->isEmpty()) {
            return response()->json(['error' => 'No logs found'], 204);
        }

        $employee = $accesslog->first()->employee;

        return response()->json([
            'employee_id' => $employee->id,
            'employee_name' => $employee->user->name,
            'employee_lastname' => $employee->user->last_name,
            'employee_department' => $employee->department->name,
            'total_accesses' => $accesslog->count(),
            'access_logs' => $accesslog
        ]);
    }

    public function exportEmployeeHistory($id = null)
    {
        if ($id) {
            $employee = Employee::with(['user', 'department'])->findOrFail($id);
            $records = AccessLog::where('employee_id', $employee->id)->get();
            $nameFile = "history_{$employee->id}_{$employee->user->name}";
            // dd($records);
        } else {
            $records = AccessLog::whereNull('employee_id')->get();
            $nameFile = "history_unknown_user";
        }

        $pdf = \PDF::loadView('pdf.employee-history', ['records' => $records, 'employee' => $employee ?? null]);

        return $pdf->download("{$nameFile}.pdf");

    }
}
