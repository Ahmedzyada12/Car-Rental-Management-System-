<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Custody;
use App\Models\Employee;
use Illuminate\Http\Request;

class CustodyController extends Controller
{
    public function index()
    {

        $custodies = Custody::all();
        $employees = Employee::all();

        return view('admin.custody.index', compact('custodies','employees'));
    }


    public function create()
    {

        $employees = Employee::all();
        return view('admin.custody.create', compact('employees'));
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'employee_id' => 'required|exists:employees,id',
            'notes' => 'required'
        ]);

        Custody::create($validatedData);
        return back();
    }


    public function api_data()
    {
        $employees = Employee::has('custodies')->with('custodies')->get();
        $transformedData = $employees->map(function ($employee) {
            return [
                'id' => $employee->id,
                'employee_id' => $employee->name,
                'amount' => $employee->custodies->sum('amount'),
                'residual_custody' => $employee->custodies->sum('residual_custody'),
                'created_at' => $employee->created_at,
            ];
        });

        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }


    public function delete($id)
    {
        Custody::where('employee_id', $id)->delete();
        return back();
    }

    public function residualCustody($id)
    {
        $employee = Employee::with('custodies')->findOrFail($id);
        $totalAmount = $employee->custodies()->sum('amount');
        $totalOfResidual = $employee->custodies()->sum('residual_custody');
        $residual = $totalAmount - $totalOfResidual;
        return view('admin.custody.residual_custody', compact('residual', 'employee'));
    }


    public function storeResidual(Request $request)
    {
        Custody::create([
            'employee_id' => $request->employee_id,
            'amount' => 0,
            'residual_custody' => $request->residual_custody,
            'notes' => $request->notes,
        ]);
        if ($request->employeeAmount == $request->residual_custody) {
            Custody::where('employee_id', $request->employee_id)->delete();
            return redirect()->route('custodies');
        }
        return back();
    }
}
