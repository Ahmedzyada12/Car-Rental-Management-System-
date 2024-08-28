<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mangers = User::where('role', 0)->get();
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
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            // Other validation rules...
        ]);
        //dd($validatedData);
        $validatedData['role'] = 0; // or whatever role you are assigning
        
        User::create($validatedData);
        //dd($validatedData);
        return redirect()->route('admin.mangers.index');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mangers = User::where('role', 0)->findOrFail($id);
        return view('admin.mangers.show', compact('mangers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, $id)
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
        //dd($validatedData);

        $mangers = User::where('role', 0)->findOrFail($id);

       

        $mangers->update($validatedData);

        return redirect()->route('admin.mangers.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $mangers = User::findOrFail($id);
        $mangers->delete();

        return redirect()->route('admin.mangers.index');
    }
}
