<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;
use App\Models\Category;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $cars = Car::where('category_id', $id)->get();


        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('admin.cars.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'category_id' => 'required|numeric|max:50',
            'name' => 'required|string|max:255',
            'hourlyprice' => 'required|string|max:255',
            'dailyprice' => 'required|string|max:255',

            // Other validation rules...
        ]);

        Car::create($validatedData);
        //dd($validatedData);
        return redirect()->route('admin.cars.index', $request->category_id);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categorys = Category::get();
        $cars = Car::with('category')->findOrFail($id);
        return view('admin.cars.show', compact('cars', 'categorys'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|numeric|max:50',
            'name' => 'required|string|max:255',
            'hourlyprice' => 'required|string|max:255',
            'dailyprice' => 'required|string|max:255',

            // Other validation rules...
        ]);
        //dd($validatedData);

        $cars = Car::findOrFail($id);



        // $car_data = $cars->update($validatedData);
        // return $cars->update($validatedData);
        $cars->update($validatedData);
        // return $cars;

        return redirect()->route('admin.cars.index', $cars->category_id);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $cars = Car::findOrFail($id);
        // $cat_id $cars->category_id;
        $cars->delete();

        // return redirect()->route('admin.cars.index');
        return back();
    }

    public function api_data($id)
    {

        $category=Category::find($id);
        $cars=$category->cars;
        $transformedData = $cars->map(function ($car) {
            return [
                'id' => $car->car_id,
                'name' => $car->name, // Adjust according to your model
                'hourlyprice' => $car->hourlyprice, // Adjust according to your model
                'dailyprice' => $car->dailyprice,
                'created_at' => $car->created_at,
            ];
        });

        $jsonData = json_encode(['data' => $transformedData]);

        return $jsonData;
    }
}
