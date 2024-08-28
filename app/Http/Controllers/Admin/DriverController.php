<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = User::where('role', 2)->get();
        $vendors = User::where('role', 4)->get();
        return view('admin.drivers.index', compact('drivers', 'vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = User::where('role', 4)->get();

        return view('admin.drivers.create', compact('vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->vendor_id) {
            $vendorId = $request->vendor_id;
        } else {
            $vendorId = Auth::user()->user_id;
        }
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
        $driver = User::where('role', 2)->findOrFail($id);
        $vendors = User::where('role', 4)->get();

        return view('admin.drivers.edit', compact('driver', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, $id)
    {

        if ($request->vendor_id) {
            $vendorId = $request->vendor_id;
        } else {
            $vendorId = Auth::user()->user_id;
        }

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
                'driver_price' => 'required|numeric',
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
                'driver_price' => 'required|numeric',
            ]);
        }
        //dd($validatedData);

        $driver = User::where('role', 2)->findOrFail($id);

        $validatedData['vendor_id'] = $vendorId; // or whatever role you are assigning

        $driver->update($validatedData);

        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $driver = User::findOrFail($id);
        $driver->delete();

        return back();
    }
    public function export()
    {
        $companys = User::where('role', 2)->get();

        $directory = public_path('storage');
        $filename = 'driver_export.csv';
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
                "driver",
            ];
            fputcsv($handle, $data);
        }
        fclose($handle);

        // return Storage::disk('public')->download($filename);
        // return download(storage_path('app/public/storage/export.csv'));
        return response()->download(public_path('storage/driver_export.csv'))->deleteFileAfterSend(true);
    }

    public function api_data()
    {
        $drivers = User::where('role', 2)->get();
        $transformedData = $drivers->map(function ($driver) {
            return [
                'id' => $driver->user_id,
                'first_name' => $driver->first_name, // Adjust according to your model
                'last_name' => $driver->last_name, // Adjust according to your model
                'email' => $driver->email,
                'address' => $driver->address, // Adjust according to your model
                'phone' => $driver->phone, // Adjust according to your model
                'price' => $driver->driver_price, // Adjust according to your model
                'vendor_id' => $driver->vendor->first_name // Adjust according to your model

            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);

        return $jsonData;
    }

    public function repairs()
    {
        return view('admin.drivers.repairs');
    }
    public function api_dataRepire()
    { {
            $repairs = Repair::all();
            $transformedData = $repairs->map(function ($repair) {
                return [
                    'id' => $repair->id,
                    'first_name' => $repair->driver->first_name, // Adjust according to your model
                    'date' => $repair->date, // Adjust according to your model

                ];
            });
            $jsonData = json_encode(['data' => $transformedData]);

            return $jsonData;
        }
    }
    public function check_email($email)
    {
        $count = User::where('email', $email)->count();
        if ($count)
            return ['exist' => true];
        return ['exist' => false];
    }
}
