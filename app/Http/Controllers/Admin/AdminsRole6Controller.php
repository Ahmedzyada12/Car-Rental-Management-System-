<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;


class AdminsRole6Controller extends Controller
{
    public function index()
    {
        $admins = User::where('role', 6)->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function api_data()
    {
        $admins = User::where('role', 6)->get();
        $transformedData = $admins->map(function ($admin) {
            return [
                'id' => $admin->user_id,
                'first_name' => $admin->first_name, // Adjust according to your model
                'last_name' => $admin->last_name, // Adjust according to your model
                'email' => $admin->email,
                'address' => $admin->address, // Adjust according to your model
                'phone' => $admin->phone // Adjust according to your model
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            // Other validation rules...
        ]);
        $validatedData['role'] = 6;
        User::create($validatedData);
        return redirect()->route('admin.adminRole.index');
    }

    public function show($id)
    {
        $admin = User::where('role', 6)->findOrFail($id);
        return view('admin.admins.edit', compact('admin'));
    }

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
        $admin = User::where('role', 6)->findOrFail($id);

        $admin->update($validatedData);
        return redirect()->route('admin.adminRole.index');
    }

    public function delete($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();
        return redirect()->route('admin.adminRole.index');
    }
}
