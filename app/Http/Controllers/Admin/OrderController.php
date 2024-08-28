<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\User;
use App\Models\About;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Category;
use App\Models\Destination;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Models\DestinationPrice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        // $orders = User::join('orders', 'users.user_id', '=', 'orders.admin_id')->distinct()->get();
        $orders = Order::with(['admin', 'company', 'customer'])->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $users = User::whereIn('role', [0, 1, 2, 3])->get();
        $admins = $users->where('role', 0);
        $companies = $users->where('role', 1);
        $companys = $companies;
        $drivers = $users->where('role', 2);
        $customers = $users->where('role', 3);
        $categoery = Category::get();

        return view('admin.orders.create', compact('admins', 'companies', 'companys', 'drivers', 'customers', 'categoery'));
    }
    public function show($id)
    {
        // return $id;
        $order = Order::with('destinations.destination')->find($id);
        // return $order;

        $users = User::whereIn('role', [0, 1, 2, 3])->get();
        $admins = $users->where('role', 0);
        $companies = $users->where('role', 1);
        $drivers = $users->where('role', 2);
        $customers = $users->where('role', 3);
        $categoery = Category::get();


        // return response()->json($order);
        return view('admin.orders.edit', compact('admins', 'companies', 'drivers', 'customers', 'categoery', 'order'));
    }
    public function edit($id, Request $request)
    {
        $request['id'] = $id; // to sent it to checkDateRange() to ignore current order on edit

        // return $request;
        $order = Order::findOrFail($id);
        $data = $request->validate([
            'car_id' => 'required|string|max:255',
            'hours' => 'required|string|max:255',
            'days' => 'required|string|max:255',
            'date_to' => 'required|date|max:255',
            'date_from' => 'required|date|max:255',
            // 'admin_id' => 'required|string|max:255',
            'company_id' => 'required|string|max:255',
            'customer_id' => 'required|string|max:255',
            'driver_id' => 'required|string|max:255',
            // 'destination' => 'required|string|max:255',
            'price' => 'required|string|max:255',
        ]);
        // $check = $this->checkDateRange($request);
        // $responseData = $check->getData();
        // if ($responseData->status == 'error') {
        //     return back()->with('error', 'This date has already been chosen');
        // }
        $data['note'] = $request->note;
        $data['admin'] = Auth::id();
        $data['destination'] = $request->destination;
        $order->update($data);

        return redirect()->route('admin.orders.index');
    }

    public function store(Request $request)
    {
        //dd($request);
        // return $request;

        $request->validate([
            'car_id' => 'required|string|max:255',
            'hours' => 'required|string|max:255',
            'days' => 'required|string|max:255',
            'date_to' => 'required|date|max:255',
            'date_from' => 'required|date|max:255',
            // 'admin_id' => 'required|string|max:255',
            'customer_id' => 'required|string|max:255',
            'company_id' => 'required|string|max:255',
            'driver_id' => 'required|string|max:255',
            // 'destination' => 'required|string|max:255',
            'price' => 'required|string|max:255',
        ]);

        // $check = $this->checkDateRange($request);
        // $responseData = $check->getData();
        // if ($responseData->status == 'error') {
        //     return back()->with('error', 'This date has already been chosen');
        // }

        $order = new Order();
        // Assuming you are receiving all necessary fields in the request
        // Add validation as required
        $order->car_id = $request->car_id;
        $order->hours = $request->hours;
        $order->days = $request->days;
        $order->date_to = $request->date_to;
        $order->date_from = $request->date_from;
        $order->admin_id = Auth::id();
        $order->company_id = $request->company_id;
        $order->driver_id = $request->driver_id;
        $order->customer_id = $request->customer_id;

        if ($request->destination) {
            $order->destination = $request->destination;
        }


        $order->price = $request->price;
        $order->date = Carbon::now()->format('Y/m/d');
        $order->read_at = Carbon::now()->format('Y/m/d');
        $order->status = 'approved';
        $order->number = random_int(10000, 99999);
        $order->note = $request->note;
        $order->save();

        // add invoice after creating order
        $invoice = new Invoice();
        $invoice->status = 2;
        $invoice->customer = $order->customer_id;
        $invoice->due_date = $order->date_from;
        $invoice->amount = $order->price;
        $invoice->paid = 0;
        $invoice->payment_method = 'Unknown';
        $invoice->save();

        // add invoice details after creating invoice
        $details = new InvoiceDetail();
        $details->invoice_id = $invoice->id;
        $details->paid = $invoice->paid;
        $details->status = 'unpaid';
        $details->save();

        return redirect()->route('admin.orders.index');
    }

    public function export()
    {
        // return Order::all()->modelKeys();
        // return Order::all();
        $directory = public_path('storage');
        $filename = 'export.csv';
        $filePath = $directory . '/' . $filename;

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $handle = fopen($filePath, 'w');

        // Write CSV header
        fputcsv($handle, [
            'order_id',
            'car',
            'admin',
            'company',
            'customer',
            'driver',
            'destination',
            'status',
            'houres number',
            'days number',
            'date from',
            'date to',
            'date of order',
            'price'
        ]);

        Order::query()
            ->each(function ($order) use ($handle) {
                $data = [
                    @$order->order_id,
                    @$order->car->name,
                    @$order->admin->first_name . " " . @$order->admin->last_name,
                    @$order->company->first_name . " " . @$order->company->last_name,
                    @$order->customer->first_name . " " . @$order->customer->last_name,
                    @$order->driver->first_name . " " . @$order->driver->last_name,
                    @$order->destination,
                    @$order->status,
                    @$order->hours,
                    @$order->days,
                    @$order->date_from,
                    @$order->date_to,
                    @$order->date,
                    @$order->price,
                ];
                fputcsv($handle, $data);
            });
        fclose($handle);

        // return Storage::disk('public')->download($filename);
        // return download(storage_path('app/public/storage/export.csv'));
        return response()->download(public_path('storage/export.csv'))->deleteFileAfterSend(true);
    }



    public function destroy($id)
    {
        Order::destroy($id);
        return back();
    }



    public function getCarsByCategory($categoryId)
    {
        $cars = Car::where('category_id', $categoryId)->pluck('name', 'car_id'); // Fetch cars for the selected category
        return  $cars; // Return them to your view
    }
    public function getCustomersByCompany($companyId)
    {
        // $customers = User::where('parent_id', $companyId)->pluck('first_name', 'user_id'); // Fetch cars for the selected category
        $customers = User::where('parent_id', $companyId)->get(['user_id', 'first_name', 'last_name']); // Fetch cars for the selected category
        return  $customers;
    }


    public function getPrice($carId, $driverId, $hours = null, $days = null, $dist_id)
    {

        // return 'price';
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

        // fawzi
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
        // fawzi

        // Assuming you have a Model that represents the entity with date ranges
        // $overlap = Order::where(function ($query) use ($dateFrom, $dateTo) {
        //     $query->where('date_from', '<=', $dateTo)
        //         ->where('date_to', '>=', $dateFrom);
        // })->exists();
        // dd($overlap);
        if ($overlap) {
            // Return JSON response for overlap
            return response()->json(['status' => 'error', 'message' => 'This date has already been chosen']);
        } else {
            // Return JSON response for no overlap
            return response()->json(['status' => 'success', 'message' => 'The selected date range is available.']);
        }
    }
    public function api_data()
    {

        $orders = Order::with(['admin', 'company', 'customer', 'destinations.destination'])->get();

        // return $orders;

        $transformedData = $orders->map(function ($order) {
            $startTime = strtotime($order->date_from);
            $starting = date('Y-m-d H:00', $startTime);
            $endTime = strtotime($order->date_to);
            $ending = date('Y-m-d H:00', $endTime);

            $from = $order->destinations->destination->from ?? 'no';
            $to = $order->destinations->destination->to ?? 'no';

            // Set destination to an empty string if both from and to are null or not defined
            $destination = ($from != 'no' || $to != 'no') ? $from . ' -> ' . $to : '';

            return [
                'id' => $order->order_id,
                'company_first_name' => $order->company->first_name . ' ' . $order->company->last_name, // Adjust according to your model
                // Adjust according to your model
                'driver_name' => $order->driver->first_name . " " . $order->driver->last_name, // Adjust according to your model
                'customer_name' => $order->customer->first_name . " " . $order->customer->last_name, // Adjust according to your model
                'price' => $order->price,
                // 'destination' => @$order->destinations->from . ' -> ' . @$order->destinations->to, // Adjust according to your model
                'destination' => $destination, // Adjust according to your model
                'date_from' => $starting, // Adjust according to your model
                'date_to' => $ending, // Adjust according to your model
                'status' => $order->status, // Adjust according to your model
                'created_at' => $order->created_at, // Adjust according to your model
                'note' => $order->note, // Adjust according to your model
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);

        return $jsonData;
    }
    public function invoice($id)
    {
        $info = About::find(1);
        $order = Order::findOrFail($id);
        $order->update(['read_at' => Carbon::now()]);
        // return $order;
        return view('admin.orders.invoice', compact('order', 'info'));
    }

    public function status($id)
    {
        $order = Order::find($id);
        if ($order) {
            if ($order->status == 'pending') {
                $order->update(['status' => 'approved']);
                $status = 'approved';
            } elseif ($order->status == 'approved') {
                $order->update(['status' => 'rejected']);
                $status = 'rejected';
            } else {
                $order->update(['status' => 'pending']);
                $status = 'pending';
            }
            return response()->json(['success' => 1, 'status' => $status]);
        } else {
            return response()->json(['success' => 0]);
        }
        // return response()->json(['id' => $id]);
    }
    public function new_status($id, $selectedValue)
    {
        $order = Order::find($id);
        $order->update(['status' => $selectedValue]);
        return 'success';
    }
    public function calindar()
    {
        $orders = Order::with(['admin', 'company', 'customer'])->get();
        $transformedData = $orders->map(function ($order) {

            return [
                'id' => $order->order_id,
                'company_first_name' => $order->company->first_name . ' ' . $order->company->last_name, // Adjust according to your model
                // Adjust according to your model
                'driver_name' => $order->driver->first_name . " " . $order->driver->last_name, // Adjust according to your model
                'customer_name' => $order->customer->first_name . " " . $order->customer->last_name, // Adjust according to your model
                'price' => $order->price,
                'title' => $order->destination, // Adjust according to your model
                'date_from' => $order->date_from, // Adjust according to your model
                'date_to' => $order->date_to, // Adjust according to your model
                'status' => $order->status, // Adjust according to your model
                'created_at' => $order->created_at, // Adjust according to your model
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);

        return $jsonData;
    }
    public function read_all()
    {

        Order::whereNull('read_at')->update(['read_at' => now()]);

        return 'success';
    }

    public function getdists($caompanyid)
    {
        // $dists = Destination::where('company_id', $caompanyid)->get();
        // return  $dists;
        $dists = DestinationPrice::with('destination')->where('company_id', $caompanyid)->get();
        return  $dists;
    }
}
