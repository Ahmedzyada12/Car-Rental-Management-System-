<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class MangerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $num_paginate = 15;

    public function index()
    {
        $mangers = User::where('role', 0)->paginate($this->num_paginate);
        return view('admin.mangers.index', compact('mangers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mangers.create');
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
        $validatedData['role'] = 0; // or whatever role you are assigning
        // $validatedData['password'] = Hash::make($request->password);

        User::create($validatedData);
        //dd($validatedData);
        return redirect()->route('admin.mang.index');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $manager = User::where('role', 0)->findOrFail($id);
        return view('admin.mangers.edit', compact('manager'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, $id)
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
        $mangers = User::where('role', 0)->findOrFail($id);


        $mangers->update($validatedData);

        return redirect()->route('admin.mang.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $mangers = User::findOrFail($id);
        $mangers->delete();

        return redirect()->route('admin.mang.index');
    }

    public function export()
    {
        $admins = User::where('role', 0)->get();

        $directory = public_path('storage');
        $filename = 'admin_export.csv';
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
        // $mangers = User::where('role', 0)->paginate($this->num_paginate);
        // return view('admin.mangers.index', compact('mangers'));
        // Fetch managers
        $managers = User::where('role', 0)->get();
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
}
