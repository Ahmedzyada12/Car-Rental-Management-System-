<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companys = User::where('role', 1)->get();


        return view('admin.companys.index', compact('companys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.companys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            // Other validation rules...
        ]);
        //dd($validatedData);
        $validatedData['role'] = 1; // or whatever role you are assigning

        User::create($validatedData);
        if (isset($request->order)) {
            return redirect()->route('admin.orders.create');
        }
        //dd($validatedData);
        return redirect()->route('admin.companys.index');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = User::where('role', 1)->findOrFail($id);
        return view('admin.companys.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, $id)
    {


        if ($request->password) {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($id, 'user_id'), // Assuming you're using the currently authenticated user
                ],
                'password' => 'required|string|min:6|confirmed',
                'phone' => 'required|string|max:255',
                'address' => 'required|string|max:255',
            ]);
            $validatedData['password'] = Hash::make($request->password);
        } else {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($id, 'user_id'), // Assuming you're using the currently authenticated user
                ],
                'phone' => 'required|string|max:255',
                'address' => 'required|string|max:255',
            ]);
        }
        //  return $validatedData;
        $company = User::where('role', 1)->findOrFail($id);

        $company->update($validatedData);
        return redirect()->route('admin.companys.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $company = User::findOrFail($id);

        User::where('parent_id', $id)->delete();
        // Order::where('company_id', $id)->delete();

        $company->delete();

        return redirect()->route('admin.companys.index');
    }
    public function export()
    {
        $companys = User::where('role', 1)->get();

        $directory = public_path('storage');
        $filename = 'company_export.csv';
        $filePath = $directory . '/' . $filename;

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $handle = fopen($filePath, 'w');

        // Write CSV header
        fputcsv($handle, [
            'id',
            'name',
            'email',
            'address',
            'phone',
            'type',
        ]);
        foreach ($companys as $company) {
            $data = [
                @$company->user_id,
                @$company->first_name . " " . @$company->last_name,
                @$company->email,
                @$company->address,
                @$company->phone,
                "company",
            ];
            fputcsv($handle, $data);
        }
        fclose($handle);
        return response()->download(public_path('storage/company_export.csv'))->deleteFileAfterSend(true);
    }
    public function api_data()
    {
        $companys = User::where('role', 1)->get();
        $transformedData = $companys->map(function ($company) {
            return [
                'id' => $company->user_id,
                'first_name' => $company->first_name, // Adjust according to your model
                'last_name' => $company->last_name, // Adjust according to your model
                'email' => $company->email,
                'address' => $company->address, // Adjust according to your model
                'phone' => $company->phone // Adjust according to your model
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);

        return $jsonData;
    }
    public function filterCustomerData(Request $request, $id)
    {
        // return $request->filter;
        if ($request->filter == 'current_month') {
            $customers = User::with('orders')->where('parent_id', $id)->whereHas('orders', function ($query) {
                $query->whereYear('date_from', '=', Carbon::now()->year)
                    ->whereMonth('date_from', '=', Carbon::now()->month);
            })->get();
            // return $customers;
        } elseif ($request->filter == 'last_month') {
            $customers = User::with('orders')->where('parent_id', $id)->whereHas('orders', function ($query) {
                $query->whereYear('date_from', '=', Carbon::now()->subMonth()->year)
                    ->whereMonth('date_from', '=', Carbon::now()->subMonth()->month);
            })->get();
            // return $customers;
        } elseif ($request->filter == 'current_year') {
            $customers = User::with('orders')->where('parent_id', $id)->whereHas('orders', function ($query) {
                $query->whereYear('date_from', '=', Carbon::now()->year);
            })->get();
            // return $customers;
        } elseif ($request->filter == 'last_year') {
            $customers = User::with('orders')->where('parent_id', $id)->whereHas('orders', function ($query) {
                $query->whereYear('date_from', '=', Carbon::now()->subYear()->year);
            })->get();
            // return $customers;
        } else {
            $customers = User::where('parent_id', $id)->get();
            // return $customers;
        }
        // $customers = User::where('parent_id', $id)->get();
        $transformedData = $customers->map(function ($customer) {
            return [
                'id' => $customer->user_id,
                'first_name' => $customer->first_name, // Adjust according to your model
                'last_name' => $customer->last_name, // Adjust according to your model
                'email' => $customer->email,
                'address' => $customer->address, // Adjust according to your model
                'phone' => $customer->phone // Adjust according to your model
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }
    public function filterOrderData(Request $request, $id)
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        // $current_month = $orders->whereBetween('date', [$startDate, $endDate]);

        if ($request->filter == 'current_month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $orders = Order::where('company_id', $id)->whereBetween('date_from', [$startDate, $endDate])->get();
        } elseif ($request->filter == 'last_month') {
            $startDate = Carbon::now()->subMonth()->startOfMonth();
            $endDate = Carbon::now()->subMonth()->endOfMonth();
            $orders = Order::where('company_id', $id)->whereBetween('date_from', [$startDate, $endDate])->get();
        } elseif ($request->filter == 'current_year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
            $orders = Order::where('company_id', $id)->whereBetween('date_from', [$startDate, $endDate])->get();
        } elseif ($request->filter == 'last_year') {
            $startDate = Carbon::now()->subYear()->startOfMonth();
            $endDate = Carbon::now()->subYear()->endOfMonth();
            $orders = Order::where('company_id', $id)->whereBetween('date_from', [$startDate, $endDate])->get();
        } else {
            $orders = Order::where('company_id', $id)->get();
        }
        // $orders = Order::where('company_id', $id)->get();
        $transformedData = $orders->map(function ($order) {

            $from = $order->destinations->destination->from ?? 'no';
            $to = $order->destinations->destination->to ?? 'no';

            // Set destination to an empty string if both from and to are null or not defined
            $destination = ($from != 'no' || $to != 'no') ? $from . ' -> ' . $to : '';


            return [
                'id' => $order->order_id,
                'company_first_name' => $order->company->first_name . ' ' . $order->company->last_name, // Adjust according to your model
                // Adjust according to your model
                'driver_name' => $order->driver->first_name . " " . $order->driver->last_name, // Adjust according to your model
                'customer_name' => $order->customer->first_name . " " . $order->customer->last_name, // Adjust according to your model
                'price' => $order->price,
                'destination' => $destination, // Adjust according to your model
                'date_from' => $order->date_from, // Adjust according to your model
                'date_to' => $order->date_to, // Adjust according to your model
                'status' => $order->status, // Adjust according to your model
                'created_at' => $order->created_at, // Adjust according to your model
                'created_at' => $order->created_at // Adjust according to your model
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }
    public function filterCustomer(Request $request, $id)
    {
        $data = [];
        $filterValue = $request->query('filter');

        if ($filterValue == 'current_month') {

            $data['customers'] = User::with('orders')->where('parent_id', $id)->whereHas('orders', function ($query) {
                $query->whereYear('date_from', '=', Carbon::now()->year)
                    ->whereMonth('date_from', '=', Carbon::now()->month);
            })->count();

            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $data['orders'] = Order::where('company_id', $id)->whereBetween('date_from', [$startDate, $endDate])->count();

            $data['sum'] = Order::where('company_id', $id)->whereBetween('date_from', [$startDate, $endDate])->sum('price');
        } elseif ($filterValue == 'last_month') {

            $data['customers'] = User::with('orders')->where('parent_id', $id)->whereHas('orders', function ($query) {
                $query->whereYear('date_from', '=', Carbon::now()->subMonth()->year)
                    ->whereMonth('date_from', '=', Carbon::now()->subMonth()->month);
            })->count();

            $startDate = Carbon::now()->subMonth()->startOfMonth();
            $endDate = Carbon::now()->subMonth()->endOfMonth();
            $data['orders'] = Order::where('company_id', $id)->whereBetween('date_from', [$startDate, $endDate])->count();

            $data['sum'] = Order::where('company_id', $id)->whereBetween('date_from', [$startDate, $endDate])->sum('price');
        } elseif ($filterValue == 'current_year') {

            $data['customers'] = User::with('orders')->where('parent_id', $id)->whereHas('orders', function ($query) {
                $query->whereYear('date_from', '=', Carbon::now()->year);
            })->count();

            $data['orders'] = Order::where('company_id', $id)->whereYear('date_from', Carbon::now()->year)->count();

            $data['sum'] = Order::where('company_id', $id)->whereYear('date_from', Carbon::now()->year)->sum('price');
        } elseif ($filterValue == 'last_year') {

            $data['customers'] = User::with('orders')->where('parent_id', $id)->whereHas('orders', function ($query) {
                $query->whereYear('date_from', '=', Carbon::now()->subYear()->year);
            })->count();

            $data['orders'] = Order::where('company_id', $id)->whereYear('date_from', Carbon::now()->subYear()->year)->count();

            $data['sum'] = Order::where('company_id', $id)->whereYear('date_from', Carbon::now()->subYear()->year)->sum('price');
        } else {
            $data['customers'] = User::where('parent_id', $id)->count();
            $data['orders'] = Order::where('company_id', $id)->count();
            $data['sum'] = Order::where('company_id', $id)->sum('price');
        }

        // $data['customers'] = User::where('parent_id', $id)->count();
        // $data['orders'] = Order::where('company_id', $id)->count();
        // $data['sum'] = Order::where('company_id', $id)->sum('price');
        // dd($customers,$orders);

        $data['company'] = User::where('user_id', $id)->first();
        return view('admin.companys.filter-company', compact('data', 'filterValue'));
    }
}
