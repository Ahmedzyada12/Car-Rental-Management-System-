<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $num_paginate = 15;

    public function index()
    {
        $vendors = User::where('role', 4)->paginate($this->num_paginate);
        return view('admin.vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // return $request;

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            // Other validation rules...
        ]);

        //dd($validatedData);
        $validatedData['role'] = 4; // or whatever role you are assigning
        // $validatedData['password'] = Hash::make($request->password);

        User::create($validatedData);
        //dd($validatedData);
        return back();
    }


    //store vendor_driver

    public function storeDriver(Request $request)
    {


            $vendorId = Auth::user()->user_id;
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'driver_price' => 'required|numeric',
            'vendor_id' => 'nullable'
            // Other validation rules...
        ]);
        //dd($validatedData);
        $validatedData['role'] = 2; // or whatever role you are assigning
        $validatedData['vendor_id'] = $vendorId; // or whatever role you are assigning

        User::create($validatedData);
        //dd($validatedData);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vendor = User::where('role', 4)->findOrFail($id);
        return view('admin.vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // return $request->password;
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
            // $validatedData['password'] = Hash::make($request->password);
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

        // return $validatedData;
        $vendors = User::where('role', 4)->findOrFail($id);


        $vendors->update($validatedData);

        return redirect()->route('admin.vendors.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $vendors = User::findOrFail($id);
        $vendors->delete();

        return redirect()->route('admin.vendors.index');
    }

    public function export()
    {
        $admins = User::where('role', 4)->get();

        $directory = public_path('storage');
        $filename = 'admin_export.csv';
        $filePath = $directory . '/' . $filename;

        if (!file_exists($directory)) {
            mkdir($directory, 4777, true);
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
        foreach ($admins as $admin) {
            $data = [
                @$admin->user_id,
                @$admin->first_name . " " . @$admin->last_name,
                @$admin->email,
                @$admin->address,
                @$admin->phone,
                "admin",
            ];
            fputcsv($handle, $data);
        }
        fclose($handle);

        // return Storage::disk('public')->download($filename);
        // return download(storage_path('app/public/storage/export.csv'));
        return response()->download(public_path('storage/admin_export.csv'))->deleteFileAfterSend(true);
    }

    public function api_data()
    {
        // $vendors = User::where('role', 4)->paginate($this->num_paginate);
        // return view('admin.vendors.index', compact('vendors'));
        // Fetch managers
        $managers = User::where('role', 4)->get();
        $transformedData = $managers->map(function ($manager) {
            return [
                'id'=>$manager->user_id,
                'first_name' => $manager->first_name, // Adjust according to your model
                'last_name' => $manager->last_name, // Adjust according to your model
                'email' => $manager->email,
                'address' => $manager->address, // Adjust according to your model
                'phone' => $manager->phone // Adjust according to your model
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);

        return $jsonData;
    }


    public function showDrivers(){
         $drivers = Auth::user()->drivers;
      return view('admin.vendors.show_drivers', compact('drivers'));

    }


    public function driver_api_data()
    {
        $drivers = Auth::user()->drivers;
         $transformedData = $drivers->map(function ($driver) {
            return [
                'id' => $driver->user_id,
                'first_name' => $driver->first_name, // Adjust according to your model
                'last_name' => $driver->last_name, // Adjust according to your model
                'email' => $driver->email,
                'address' => $driver->address, // Adjust according to your model
                'phone' => $driver->phone, // Adjust according to your model
                'price' => $driver->driver_price, // Adjust according to your model

            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);

        return $jsonData;
    }

    public function showDriver($id)
    {
          $driver = User::where('role', 2)->findOrFail($id);
        return view('admin.drivers.edit', compact('driver'));
    }


    public function api_dataOrder()
    {
            // $orders = Order::with(['admin', 'company', 'customer'])->get();


        // return $orders;
            $orders = Order::join('cars', 'cars.car_id', '=', 'orders.car_id')->join('categories', 'categories.category_id', '=', 'cars.category_id')->join('users', 'users.user_id', '=', 'categories.vendor_id')->where('users.user_id', auth()->user()->user_id)
            ->get();

        $transformedData = $orders->map(function ($order) {
            $startTime = strtotime($order->date_from);
            $starting = date('Y-m-d H:00', $startTime);
            $endTime = strtotime($order->date_to);
            $ending = date('Y-m-d H:00', $endTime);

            $from = $order->destinations->from ?? 'no';
            $to = $order->destinations->to ?? 'no';

            // Set destination to an empty string if both from and to are null or not defined
            $destination = ($from != 'no' || $to != 'no') ? $from . ' -> ' . $to : '';

            return [
                'id' => $order->order_id,
                'company_first_name' => $order->company->first_name . ' ' . $order->company->last_name, // Adjust according to your model
                // Adjust according to your model
                'driver_name' => $order->driver->first_name . " " . $order->driver->last_name, // Adjust according to your model
                'customer_name' => $order->customer->first_name . " " . $order->customer->last_name, // Adjust according to your model
                'price' => $order->price,
                // 'destination' => @$order->destinations->from . ' -> ' . @$order->destinations->to, // Adjust according to your model
                'destination' => $destination, // Adjust according to your model
                'date_from' => $starting, // Adjust according to your model
                'date_to' => $ending, // Adjust according to your model
                'status' => $order->status, // Adjust according to your model
                'created_at' => $order->created_at, // Adjust according to your model
                'note' => $order->note, // Adjust according to your model
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);

        return $jsonData;
    }

    public function orders()
    {

        $orders = Order::join('cars', 'cars.car_id', '=', 'orders.car_id')->join('categories', 'categories.category_id', '=', 'cars.category_id')->join('users', 'users.user_id', '=', 'categories.vendor_id')->where('users.user_id', auth()->user()->user_id)
        ->get();
    return view('admin.vendors.orders', compact('orders'));
    }

}
