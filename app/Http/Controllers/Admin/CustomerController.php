<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use DougSisk\CountryState\CountryState;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = User::where('role', 3)->get();
        $companys = User::where('role', 1)->get();
        $countryStateInstance = new CountryState();
        $countries = $countryStateInstance->getCountries();
        $states = $countryStateInstance->getStates('EG');

        return view('admin.customers.index', compact('customers', 'companys', 'countries', 'states'));
    }



    public function get_states($country)
    {

        $countryName = strtoupper($country);
        $firstTwoCharacters = substr($countryName, 0, 2);

        $countryStateInstance = new CountryState();

        $states = $countryStateInstance->getStates($firstTwoCharacters);
        return json_encode($states);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companys = User::where('role', 1)->get();

        $countryStateInstance = new CountryState();
        $countries = $countryStateInstance->getCountries();

        // dd($companys);
        return view('admin.customers.create', compact('companys', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'parent_id' => 'required|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255'
            // 'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:6|confirmed',
            // Other validation rules...
        ]);
        //dd($validatedData);
        //dd($request);


        $validatedData['parent_id'] = $request->parent_id; // or whatever role you are assigning
        $validatedData['email'] = uniqid() . random_int(0, 5000) . '@customer.com'; // or whatever role you are assigning
        $validatedData['password'] = time(); // or whatever role you are assigning

        $validatedData['role'] = 3; // or whatever role you are assigning
        // dd($validatedData);
        User::create($validatedData);
        if (isset($request->order)) {
            return redirect()->route('admin.orders.create');
        }
        return redirect()->route('admin.customer.index');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = User::where('role', 3)->findOrFail($id);

        $countryStateInstance = new CountryState();
        $countries = $countryStateInstance->getCountries();

        return view('admin.customers.edit', compact('customer', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',

        ]);
        //dd($validatedData);

        $customer = User::where('role', 3)->findOrFail($id);



        $customer->update($validatedData);

        return redirect()->route('admin.customer.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $customer = User::findOrFail($id);

        // Order::where('customer_id', $id)->delete();

        $customer->delete();


        return back();
    }
    public function export()
    {
        $companys = User::where('role', 3)->get();

        $directory = public_path('storage');
        $filename = 'customer_export.csv';
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
                "customer",
            ];
            fputcsv($handle, $data);
        }
        fclose($handle);
        return response()->download(public_path('storage/customer_export.csv'))->deleteFileAfterSend(true);
    }
    public function api_data()
    {
        $customers = User::where('role', 3)->get();
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
    public function filterOrderData($id)
    {
        $orders = Order::with('destinations.destination')->where('customer_id', $id)->get();
        $transformedData = $orders->map(function ($order) {
            $timestamp = strtotime($order->date_from);

            // Format the date using the date() function
            $formattedCreatedAt = date('Y-m-d H:00', $timestamp);
            $from = $order->destinations->destination->from ?? 'no';
            $to = $order->destinations->destination->to ?? 'no';

            // Set destination to an empty string if both from and to are null or not defined
            $destination = ($from != 'no' || $to != 'no') ? $from . ' -> ' . $to : '';
            return [
                'id' => $order->order_id,
                'company_first_name' => $order->company->first_name . ' ' . $order->company->last_name, // Adjust according to your model
                'driver_name' => $order->driver->first_name . " " . $order->driver->last_name, // Adjust according to your model
                'customer_name' => $order->customer->first_name . " " . $order->customer->last_name, // Adjust according to your model
                'price' => $order->price,
                'destination' => $destination, // Adjust according to your model
                'date_from' => $formattedCreatedAt, // Adjust according to your model
                'date_to' => $order->date_to, // Adjust according to your model
                'status' => $order->status, // Adjust according to your model
                'created_at' => $order->created_at // Adjust according to your model
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }
    public function filterCustomer($id)
    {
        $data = [];
        $data['orders'] = Order::where('customer_id', $id)->count();
        $data['sum'] = Order::where('customer_id', $id)->sum('price');
        $data['customer'] = User::where('user_id', $id)->first();
        // dd($customers,$orders);
        return view('admin.customers.filter-customer', compact('data'));
    }
}
