<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Repair;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $orders = Order::where('driver_id', auth()->id())->get();
        // return $orders;
        return view('driver.orders', compact('orders'));
    }
    public function api_data_order()
    {
        $orders = Order::with('destinations.destination')->where('driver_id', auth()->id())->get();

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
                // 'company_first_name' => $order->company->first_name . ' ' . $order->company->last_name, // Adjust according to your model
                // Adjust according to your model
                'date_from' => $starting, // Adjust according to your model
                'customer_name' => $order->customer->first_name . " " . $order->customer->last_name, // Adjust according to your model
                'date_to' => $ending, // Adjust according to your model
                'hours' => $order->hours, // Adjust according to your model
                'days' => $order->days, // Adjust according to your model
                'status' => $order->status, // Adjust according to your model
                'destination' => $destination, // Adjust according to your model
                // 'note' => $order->note, // Adjust according to your model
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);

        return $jsonData;
    }

    public function show_repair()
    {
        return view('driver.repair');
    }

    public function store_repair(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date|max:255',
        ]);
        $driver_id = auth()->id();
        $validatedData['driver_id'] = $driver_id;
        $repair = Repair::create($validatedData);
        if ($repair) {
            return back();
        }
        return "not creating";
    }
}
