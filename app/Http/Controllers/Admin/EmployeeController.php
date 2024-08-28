<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Discount;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index()
    {

        $employees = Employee::all();
        return view('admin.employees.index', compact('employees'));
    }


    public function create()
    {

        return view('admin.employees.create');
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:100|unique:employees',
            'job' => 'required|string|max:100',
            'salary' => 'required|integer',
        ]);
        Employee::create($validatedData);
        return back();
    }


    public function show($id)
    {
        $employee = Employee::findOrfail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:100|unique:employees,email,' . $id,
            'job' => 'required|string|max:100',
            'salary' => 'required|integer',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return back();
    }
    public function api_data()
    {


        $employees = Employee::all();
        $transformedData = $employees->map(function ($employee) {
            return [
                'id' => $employee->id,
                'name' => $employee->name,
                'phone' => $employee->phone,
                'address' => $employee->address,
                'email' => $employee->email,
                'job' => $employee->job,
                'salary' => $employee->salary,
                'created_at' => $employee->created_at,
            ];
        });

        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }


    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return back();
    }


    public function profile($id)
    {
        return view('admin.employees.employee_profile', compact('id'));
    }

    public function profile_driver($id)
    {
        return view('admin.employees.driver_profile', compact('id'));
    }

    public function apiDataProfile(Request $request, $id)
    {



        if ($request->year == 'null' && $request->month == 'null') {
            $employeeDiscounts = Discount::where('employee_id', $id)->get();
        } else {
            $employeeDiscounts = Discount::where('employee_id', $id)->where('month', $request->month)->where('year', $request->year)->get();
        }
        $transformedData = $employeeDiscounts->map(function ($discount) {
            return [
                'id' => $discount->id,
                'amount' => $discount->amount,
                'reason' => $discount->reason,
                'month' => $discount->month,
                'year' => $discount->year,
                'created_at' => Carbon::parse($discount->created_at)->format('Y-m-d'),

            ];
        });

        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }


    public function apiDataProfile_driver(Request $request, $id)
    {



        if ($request->year == 'null' && $request->month == 'null') {
            $employeeDiscounts = Discount::where('driver_id', $id)->get();
        } else {
            $employeeDiscounts = Discount::where('driver_id', $id)->where('month', $request->month)->where('year', $request->year)->get();
        }
        $transformedData = $employeeDiscounts->map(function ($discount) {
            return [
                'id' => $discount->id,
                'amount' => $discount->amount,
                'reason' => $discount->reason,
                'month' => $discount->month,
                'year' => $discount->year,
                'created_at' => Carbon::parse($discount->created_at)->format('Y-m-d'),

            ];
        });

        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }
}
