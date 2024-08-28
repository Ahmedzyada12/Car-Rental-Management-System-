<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class AccountantController extends Controller
{
    public function index()
    {
        $accountants = User::where('role', 5)->get();
        return view('admin.accountants.index', compact('accountants'));
    }

    public function api_data()
    {
        $accountants = User::where('role', 5)->get();
        $transformedData = $accountants->map(function ($accountant) {
            return [
                'id' => $accountant->user_id,
                'first_name' => $accountant->first_name, // Adjust according to your model
                'last_name' => $accountant->last_name, // Adjust according to your model
                'email' => $accountant->email,
                'address' => $accountant->address, // Adjust according to your model
                'phone' => $accountant->phone // Adjust according to your model
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }

    public function create()
    {
        return view('admin.accountants.create');
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
        $validatedData['role'] = 5;
        User::create($validatedData);
        return redirect()->route('admin.Accountant.index');
    }

    public function show($id)
    {
        $accountant = User::where('role', 5)->findOrFail($id);
        return view('admin.accountants.edit', compact('accountant'));
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
        $accountant = User::where('role', 5)->findOrFail($id);

        $accountant->update($validatedData);
        return redirect()->route('admin.Accountant.index');
    }

    public function delete($id)
    {
        $accountant = User::findOrFail($id);
        $accountant->delete();
        return redirect()->route('admin.Accountant.index');
    }
}
