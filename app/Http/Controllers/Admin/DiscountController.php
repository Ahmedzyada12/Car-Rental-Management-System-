<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Discount;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DiscountController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $users = User::where('role', '2')->get();

        return view('admin.discounts.index', compact('employees', 'users'));
    }


    public function create()
    {
        $employees = Employee::all();
        $drivers = User::where('role', '2')->get();
        return view('admin.discounts.create', compact('employees', 'drivers'));
    }

    public function show($id)
    {

        $discount = Discount::findOrFail($id);
        $employees = Employee::all();
        return view('admin.discounts.edit', compact('employees', 'discount'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'reason' => 'required|string',
            'employee_id' => 'required|exists:employees,id',
        ]);

        $discount = Discount::findOrFail($id);
        $discount->update($request->all());

        return back();
    }

    public function store(Request $request)
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        if ($request->employee_id == null) {
            // return "driver";
            $validatedData = $request->validate([
                'amount' => 'required|numeric',
                'reason' => 'required|string',
                // 'employee_id' => 'required|exists:employees,id',
                'driver_id' => 'required',
            ]);
        } else {
            // return "employee";

            $validatedData = $request->validate([
                'amount' => 'required|numeric',
                'reason' => 'required|string',
                'employee_id' => 'required|exists:employees,id',
            ]);
        }
        $validatedData['month'] = $currentMonth;
        $validatedData['year'] = $currentYear;

        Discount::create($validatedData);

        return back();
    }

    public function store_for_driver(Request $request)
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'reason' => 'required|string',
            'driver_id' => 'required',
        ]);

        $validatedData['month'] = $currentMonth;
        $validatedData['year'] = $currentYear;

        Discount::create($validatedData);

        return back();
    }

    public function api_data()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $employees = Employee::has('discounts')
            ->with(['discounts' => function ($query) use ($currentMonth, $currentYear) {
                $query->where('month', $currentMonth)->where('year', $currentYear);
            }])
            ->get();
        $transformedData = $employees->map(function ($employee) {
            return [
                'id' => $employee->id,
                'employee_id' => $employee->name,
                'amount' => $employee->discounts->sum('amount'),
            ];
        });

        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }


    public function delete($id)
    {
        Discount::where('employee_id', $id)->delete();
        return back();
    }

    public function driver()
    {
        return Discount::where('driver_id', '!=', null)->get();
    }
    public function api_data_driver_discount()
    {
        // $currentYear = now()->year;
        // $currentMonth = now()->month;

        // $usersWithDiscounts = Discount::join('users', 'discounts.driver_id', '=', 'users.user_id')
        //     ->select('discounts.*', 'users.*') // Select all columns from both tables
        //     ->get();
        // return $usersWithDiscounts;
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // $usersWithDiscounts = Discount::join('users', 'discounts.driver_id', '=', 'users.user_id')
        //     ->select('discounts.*', 'users.*') // Select all columns from both tables
        //     ->get();

        $employees = User::has('discounts')
            ->with(['discounts' => function ($query) use ($currentMonth, $currentYear) {
                $query->where('month', $currentMonth)->where('year', $currentYear);
            }])
            ->get();

        $transformedData = $employees->map(function ($employee) {
            return [
                'id' => $employee->id,
                'driver_name' => $employee->first_name,
                // 'amount' => $employee->amount,
                'amount' => $employee->discounts->sum('amount'),

            ];
        });

        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }
}
