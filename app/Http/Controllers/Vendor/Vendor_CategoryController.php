<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Vendor_CategoryController extends Controller
{

    public function index(){

        return view('admin.vendors.categories');
    }

    public function create(){

        return view('admin.category.create');
    }


    public function store(Request $request)
    {
        //dd($request);
         $vendorId=Auth::user()->user_id;
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'hourlyprice' => 'required|string|max:255',
            'dailyprice' => 'required|string|max:255',

            // Other validation rules...
        ]);

        $validatedData['vendor_id']=$vendorId;
        Category::create($validatedData);
        //dd($validatedData);
        return back();
    }


    public function createCar()
    {

          $categories =Auth::user()->categories;
       return view('admin.cars.create', compact('categories'));
    }


    public function StoreCar(Request $request)
    {

        $validatedData = $request->validate([
            'category_id' => 'required|numeric|max:50',
            'name' => 'required|string|max:255',
            'hourlyprice' => 'required|string|max:255',
            'dailyprice' => 'required|string|max:255',

            // Other validation rules...
        ]);

        Car::create($validatedData);
        //dd($validatedData);
        return back();

    }


public function api_data()
    {
        $categories =Auth::user()->categories;
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


    public function showCategory($id)
    {
         $category = Category::findOrFail($id);
        return view('admin.category.show', compact('category'));
    }


    public function updateCategory(Request $request, $id)
    {

        $vendorId=Auth::user()->user_id;
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'hourlyprice' => 'required|string|max:255',
            'dailyprice' => 'required|string|max:255',

            // Other validation rules...
        ]);
        //dd($validatedData);

        $category = Category::findOrFail($id);

        $validatedData['vendor_id']=$vendorId;

        $category->update($validatedData);

        return back();
    }


    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return back();
    }


    public function showCars($id){

        $category=Category::find($id);
        $cars=$category->cars;
        return view('admin.vendors.show_cars', compact('cars'));

    }


    public function api_data_cars($id)
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

    public function showCar($id)
    {
        $categories = Category::get();
        $cars = Car::with('category')->findOrFail($id);
        return view('admin.cars.show', compact('cars', 'categories'));
    }


    public function deleteCar($id)
    {
        $cars = Car::findOrFail($id);
        // $cat_id $cars->category_id;
        $cars->delete();

        // return redirect()->route('admin.cars.index');
        return back();
    }


    public function updateCar(Request $request, $id)
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

        return back();
    }
}
