<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Category;
use App\Models\Destination;
use App\Models\DestinationPrice;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function customer()
    {
        return view('company.create_customer');
    }
    public function storeCustomer(Request $request)
    {
        // return $request;
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $validatedData['parent_id'] = auth()->id(); // or whatever role you are assigning
        $validatedData['role'] = 3; // or whatever role you are assigning
        $validatedData['password'] = 'kfsfh345g32@^@G^255435#543';
        // return $validatedData;
        User::create($validatedData);
        return back()->with('success', 'Added successfully');
    }
    public function order()
    {
        $users = User::whereIn('role', [2, 3])->get();
        // $companies = $users->where('role', 1);
        // $companys = $companies;
        $drivers = $users->where('role', 2);
        $customers = $users->where('role', 3)->where('parent_id', auth()->user()->user_id);
        $destinations = DestinationPrice::with('destination')->where('company_id', auth()->user()->user_id)->get();
        // return $destinations;
        $categoery = Category::get();

        return view('company.create_order', compact('drivers', 'customers', 'categoery', 'destinations'));
    }
    public function storeOrder(Request $request)
    {
        $validatedData = $request->validate([
            'date_from' => 'required|string|max:255',
            'date_to' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'car_id' => 'required|string|max:255',
            'customer_id' => 'required|string|max:255',
            'driver_id' => 'required|string|max:255',
            'hours' => 'required|string|max:255',
            'days' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            // 'destination' => 'required|string|max:255',
        ]);

        // $check = $this->checkDateRange($request);
        // $responseData = $check->getData();
        // if ($responseData->status == 'error') {
        //     return back()->with('error', 'هذالتاريخ تم اختياره من قبل');
        // }

        $validatedData['status'] = 'pending';
        $validatedData['number'] = random_int(10000, 99999);
        $validatedData['company_id'] = auth()->id();
        $validatedData['note'] = $request->note;
        $validatedData['destination'] = $request->destination;
        $validatedData['date'] = Carbon::now()->format('Y/m/d');

        Order::create($validatedData);
        return back()->with('success', 'Added successfully');
    }
    public function orders()
    {
        $orders = Order::where('company_id', auth()->id())->get();
        return view('company.orders', compact('orders'));
    }
    public function customers()
    {
        $customers = User::where('parent_id', auth()->id())->get();
        return view('company.customers', compact('customers'));
    }

    public function getCarsByCategory($categoryId)
    {
        $cars = Car::where('category_id', $categoryId)->pluck('name', 'car_id'); // Fetch cars for the selected category
        return  $cars; // Return them to your view
    }

    public function getPrice($carId, $driverId, $hours = null, $days = null, $dist_id)
    {

        $car = Car::with('category')->findOrFail($carId);
        $driver_price = User::findOrFail($driverId)->driver_price;

        if ($dist_id) {
            $dist_price = DestinationPrice::findOrFail($dist_id)->price;
        } else {
            $dist_price = 0;
        }


        $price_obj = [
            'hours' => $hours,
            'days' => $days,
            'car_price_horly' => @$car->hourlyprice,
            'car_price_daily' => @$car->dailyprice,
            'cat_price_horly' => @$car->category->hourlyprice,
            'cat_price_daily' => @$car->category->dailyprice
        ];


        if ($car->hourlyprice != null) {
            $total_hors_price  =  $hours *  $car->hourlyprice;
        } else {
            $total_hors_price  =  $hours * $car->category->hourlyprice;
        }

        if ($car->dailyprice != null) {
            $total_daily_price  =  $days *  $car->dailyprice;
        } else {
            $total_daily_price  =  $days * $car->category->dailyprice;
        }
        $total_price = $total_hors_price + $total_daily_price + $driver_price + $dist_price;

        return compact('price_obj', 'total_hors_price', 'total_daily_price', 'total_price');
    }

    public function checkDateRange(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        if ($request->has('id')) {
            $id = $request->input('id');
            $overlap = Order::where(function ($query) use ($dateFrom, $dateTo, $id) {
                $query->where('date_from', '<=', $dateTo)
                    ->where('date_to', '>=', $dateFrom)
                    ->where('order_id', '!=', $id);
            })->exists();
        } else {
            $overlap = Order::where(function ($query) use ($dateFrom, $dateTo) {
                $query->where('date_from', '<=', $dateTo)
                    ->where('date_to', '>=', $dateFrom);
            })->exists();
        }

        if ($overlap) {
            // Return JSON response for overlap
            return response()->json(['status' => 'error', 'message' => 'هذالتاريخ تم اختياره من قبل']);
        } else {
            // Return JSON response for no overlap
            return response()->json(['status' => 'success', 'message' => 'The selected date range is available.']);
        }
    }
    public function api_data_customer()
    {
        $customers = User::where('parent_id', auth()->id())->get();
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
    public function api_data_order()
    {
        $orders = Order::with('destinations.destination')->where('company_id', auth()->id())->get();
        // return $orders;

        $transformedData = $orders->map(function ($order) {
            $startTime = strtotime($order->date_from);
            $starting = date('Y-m-d H:00', $startTime);
            $endTime = strtotime($order->date_to);
            $ending = date('Y-m-d H:00', $endTime);


            $from = $order->destinations->destination->from ?? 'no';
            $to = $order->destinations->destination->to ?? 'no';
            $destination = ($from != 'no' || $to != 'no') ? $from . ' -> ' . $to : '';


            return [
                'id' => $order->order_id,
                'company_first_name' => $order->company->first_name . ' ' . $order->company->last_name, // Adjust according to your model
                // Adjust according to your model
                'driver_name' => $order->driver->first_name . " " . $order->driver->last_name, // Adjust according to your model
                'customer_name' => $order->customer->first_name . " " . $order->customer->last_name, // Adjust according to your model
                'price' => $order->price,
                'destination' => $destination, // Adjust according to your model
                'date_from' => $starting, // Adjust according to your model
                'date_to' => $ending, // Adjust according to your model
                'status' => $order->status, // Adjust according to your model
                'note' => $order->note, // Adjust according to your model
                'created_at' => $order->created_at, // Adjust according to your model
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);

        return $jsonData;
    }
    public function show($id)
    {
        $customer = User::findOrFail($id);
        return view('company.edit_customer', compact('customer'));
    }
    public function edit(Request $request)
    {

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($request->id, 'user_id'), // Assuming you're using the currently authenticated user
            ],
            // 'email' => 'unique:users,email,' . $request->id,
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);
        $customer = User::findOrFail($request->id);


        $customer->update($validatedData);

        return back()->with('success', 'Updated successfully');;
    }
    public function order_show($id)
    {
        $order = Order::findOrFail($id);
        $users = User::whereIn('role', [2, 3])->get();
        $drivers = $users->where('role', 2);
        $customers = $users->where('role', 3)->where('parent_id', auth()->user()->user_id);
        $categoery = Category::get();
        $destinations = DestinationPrice::with('destination')->where('company_id', auth()->user()->user_id)->get();

        return view('company.edit_order', compact('order', 'drivers', 'customers', 'categoery', 'destinations'));
    }
    public function order_edit(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $data = $request->validate([
            'car_id' => 'required|string|max:255',
            'hours' => 'required|string|max:255',
            'days' => 'required|string|max:255',
            'date_to' => 'required|date|max:255',
            'date_from' => 'required|date|max:255',
            // 'admin_id' => 'required|string|max:255',
            'customer_id' => 'required|string|max:255',
            'driver_id' => 'required|string|max:255',
            // 'destination' => 'required|string|max:255',
            'price' => 'required|string|max:255',
        ]);
        // $check = $this->checkDateRange($request);
        // $responseData = $check->getData();
        // if ($responseData->status == 'error') {
        //     return back()->with('error', 'هذالتاريخ تم اختياره من قبل');
        // }
        $data['note'] = $request->note;

        $data['destination'] = $request->destination;

        $order->update($data);
        return back()->with('success', 'Updated successfully');
    }
    public function delete($id)
    {
        User::findOrFail($id)->delete();
        return back();
    }

    public function destinations()
    {
        return view('company.destinations');
    }
    public function api_dists()
    {
        $destinations = Destination::where('company_id', auth()->id())->get();
        $transformedData = $destinations->map(function ($destination) {
            return [
                'id' => $destination->id, // Adjust according to your model
                'from' => $destination->from, // Adjust according to your model
                'to' => $destination->to, // Adjust according to your model
                'price' => $destination->price, // Adjust according to your model
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }
    public function store_dists(Request $request)
    {
        // return $request;
        $request->validate([
            'from' => 'required|max:255',
            'to' => 'required|max:255',
            'price' => 'numeric',
        ]);
        $dist = new Destination();
        $dist->from = $request->from;
        $dist->to = $request->to;
        $dist->price = $request->price;
        $dist->company_id = auth()->id();
        $dist->save();
        return back();
    }
    public function delete_dists($id)
    {
        Destination::findOrFail($id)->delete();
        return back();
    }
}
