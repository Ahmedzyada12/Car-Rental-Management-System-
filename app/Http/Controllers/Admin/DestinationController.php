<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\DestinationPrice;
use App\Models\User;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::with('prices')->get();
        return view('admin.destinations.index', compact('destinations'));
    }
    public function create()
    {
        return view('admin.destinations.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'from' => 'required|max:255',
            'to' => 'required|max:255',
        ]);
        Destination::create($data);
        return back()->with('success', 'added successfully');
    }
    public function update(Request $request)
    {
        // return $request;
        $dest = Destination::findOrFail($request->id);
        $data = $request->validate([
            'from' => 'required|max:255',
            'to' => 'required|max:255',
        ]);
        $dest->update($data);
        return back()->with('success', 'updated successfully');
    }
    public function delete($id)
    {
        Destination::where('id', $id)->delete();
        return back();
    }
    public function prices()
    {
        $destinations = DestinationPrice::with('destination', 'company')->get();
        $companies = User::where('role', 1)->get();
        $dest_lists = Destination::get();
        return view('admin.destinations.destination_prices', compact('destinations', 'companies', 'dest_lists'));
    }
    public function create_price()
    {
        $destinations = Destination::all();
        $companies = User::where('role', 1)->get();
        return view('admin.destinations.create_price', compact('destinations', 'companies'));
    }
    public function store_price(Request $request)
    {
        $data = $request->validate([
            'destination_id' => 'required|max:255|exists:destinations,id',
            'company_id' => 'required|max:255|exists:users,user_id',
            'price' => 'required|max:255',
        ]);
        DestinationPrice::create($data);
        return back()->with('success', 'added successfully');
    }
    public function update_price(Request $request)
    {
        // return $request;
        $dest = DestinationPrice::findOrFail($request->id);
        $data = $request->validate([
            'company_id' => 'required|max:255',
            'destination_id' => 'required|max:255',
            'price' => 'required|numeric',
        ]);
        $dest->update($data);
        return back()->with('success', 'updated successfully');
    }
    public function delete_price($id)
    {
        DestinationPrice::where('id', $id)->delete();
        return back();
    }
}
