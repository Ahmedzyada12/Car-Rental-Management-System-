<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if (auth()->user()->role == 4) {

            $totalCars = Car::join('categories', 'categories.category_id', '=', 'cars.category_id')
                ->join('users', 'users.user_id', '=', 'categories.vendor_id')
                ->where('users.role', 4)
                ->where('users.user_id', auth()->user()->user_id)
                ->count();
            $user = User::find(auth()->user()->user_id);
            $totalDrivers = $user->drivers->count();

            $orders = Order::join('cars', 'cars.car_id', '=', 'orders.car_id')->join('categories', 'categories.category_id', '=', 'cars.category_id')->join('users', 'users.user_id', '=', 'categories.vendor_id')->where('users.user_id', auth()->user()->user_id)
                ->get();
            $totalOrders = Order::join('cars', 'cars.car_id', '=', 'orders.car_id')->join('categories', 'categories.category_id', '=', 'cars.category_id')->join('users', 'users.user_id', '=', 'categories.vendor_id')->where('users.user_id', auth()->user()->user_id)
                ->count();

            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $current_month = $orders->whereBetween('date', [$startDate, $endDate]);
            $totalPrice = $current_month->sum('price');
            return view('admin.dashboard', compact('totalCars', 'totalDrivers', 'totalOrders', 'totalPrice', 'orders'));
        }
        if (auth()->user()->role == 0 || Auth::user()->role == 6) {
            $users = User::whereIn('role', [1, 2, 3])->get();
            $companies = $users->where('role', 1)->count();
            $drivers = $users->where('role', 2)->count();
            $customers = $users->where('role', 3)->count();
            $categoery = Category::get()->count();
            $cars = Car::all()->count();

            $orders = Order::all();

            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $current_month = $orders->whereBetween('date', [$startDate, $endDate]);
            $current_month = $current_month->sum('price');

            // return $orders->count();
            return view('admin.dashboard', compact('companies', 'drivers', 'customers', 'categoery', 'cars', 'orders', 'current_month'));
        }
        return view('admin.dashboard');
    }
    public function charts()
    {
        $all_orders = Order::all()->sum('price');
        $approved_orders = Order::where('status', 'approved')->get()->sum('price');
        $pending_orders = Order::where('status', 'pending')->get()->sum('price');
        $rejected_orders = Order::where('status', 'rejected')->get()->sum('price');

        $approved_orders = number_format($approved_orders * 100 / $all_orders, 1);
        $pending_orders = number_format($pending_orders * 100 / $all_orders, 1);
        $rejected_orders = number_format($rejected_orders * 100 / $all_orders, 1);

        return response()->json([
            'approved_orders' => $approved_orders,
            'pending_orders' => $pending_orders,
            'rejected_orders' => $rejected_orders,
        ]);
    }
    public function calender()
    {
        $orders = Order::all();
        $today = now()->addHours(2);
        $transformedData = $orders->map(function ($order) use ($today) {

            $date_from = Carbon::parse($order->date_from);
            if ($today->lt($date_from)) {
                $check = $date_from->diff($today);
                if ($check->days == 0) {
                    $style = 'Holiday';
                } else {
                    $style = 'Business';
                }
            } else {
                $style = 'Personal';
            }
            return [
                'id' => $order->order_id,
                'url' => 'admin/orders/invoice/' . $order->order_id,
                'title' => $order->customer->first_name,
                'start' => $order->date_from,
                'end' => $order->date_to,
                'allDay' => false,
                'extendedProps' => ['calendar' => $style],
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }
    public function calender_driver()
    {
        // $orders = Order::all();
        $orders = Order::where('driver_id', auth()->id())->get();
        $today = now()->addHours(2);
        $transformedData = $orders->map(function ($order) use ($today) {

            $date_from = Carbon::parse($order->date_from);
            if ($today->lt($date_from)) {
                $check = $date_from->diff($today);
                if ($check->days == 0) {
                    $style = 'Holiday';
                } else {
                    $style = 'Business';
                }
            } else {
                $style = 'Personal';
            }
            return [
                'id' => $order->order_id,
                // 'url' => 'admin/orders/invoice/' . $order->order_id,
                'title' => $order->customer->first_name,
                'start' => $order->date_from,
                'end' => $order->date_to,
                'allDay' => false,
                'extendedProps' => ['calendar' => $style],
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }

    public function calender_vendor()
    {
        // $orders = Order::all();
        $orders = Order::join('cars', 'cars.car_id', '=', 'orders.car_id')->join('categories', 'categories.category_id', '=', 'cars.category_id')->join('users', 'users.user_id', '=', 'categories.vendor_id')->where('users.user_id', auth()->user()->user_id)
            ->get();

        $today = now()->addHours(2);
        $transformedData = $orders->map(function ($order) use ($today) {

            $date_from = Carbon::parse($order->date_from);
            if ($today->lt($date_from)) {
                $check = $date_from->diff($today);
                if ($check->days == 0) {
                    $style = 'Holiday';
                } else {
                    $style = 'Business';
                }
            } else {
                $style = 'Personal';
            }
            return [
                'id' => $order->order_id,
                // 'url' => 'admin/orders/invoice/' . $order->order_id,
                'title' => $order->customer->first_name,
                'start' => $order->date_from,
                'end' => $order->date_to,
                'allDay' => false,
                'extendedProps' => ['calendar' => $style],
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }

    public function calender_company()
    {
        // $orders = Order::all();
        $orders = Order::where('company_id', auth()->id())->get();
        $today = now()->addHours(2);
        $transformedData = $orders->map(function ($order) use ($today) {

            $date_from = Carbon::parse($order->date_from);
            if ($today->lt($date_from)) {
                $check = $date_from->diff($today);
                if ($check->days == 0) {
                    $style = 'Holiday';
                } else {
                    $style = 'Business';
                }
            } else {
                $style = 'Personal';
            }
            return [
                'id' => $order->order_id,
                // 'url' => 'admin/orders/invoice/' . $order->order_id,
                'title' => $order->customer->first_name,
                'start' => $order->date_from,
                'end' => $order->date_to,
                'allDay' => false,
                'extendedProps' => ['calendar' => $style],
            ];
        });
        $jsonData = json_encode(['data' => $transformedData]);
        return $jsonData;
    }


    public function year($id)
    {
        $orders = Order::whereYear('date_from', $id)->get();
        return [
            // 'data' => $orders,
            'price' => $orders->sum('price'),
            'count' => $orders->count(),
        ];
    }
}
