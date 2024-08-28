<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::get();


        return view('admin.category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'hourlyprice' => 'required|string|max:255',
            'dailyprice' => 'required|string|max:255',
            // Other validation rules...
        ]);

        Category::create($validatedData);
        //dd($validatedData);
        return redirect()->route('admin.category.index');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.show', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'hourlyprice' => 'required|string|max:255',
            'dailyprice' => 'required|string|max:255',

            // Other validation rules...
        ]);
        //dd($validatedData);

        $category = Category::findOrFail($id);



        $category->update($validatedData);

        return redirect()->route('admin.category.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.category.index');
    }
    public function api_data()
    {
        // $mangers = User::where('role', 0)->paginate($this->num_paginate);
        // return view('admin.mangers.index', compact('mangers'));
        // Fetch managers
        $categories = Category::all();
        $transformedData = $categories->map(function ($category) {
            return [
                'id'=>$category->category_id,
                'name' => $category->name, // Adjust according to your model
                'hourlyprice' => $category->hourlyprice, // Adjust according to your model
                'dailyprice' => $category->dailyprice,
                'created_at' => $category->created_at,
            ];
        });

        $jsonData = json_encode(['data' => $transformedData]);

        return $jsonData;
    }
}
