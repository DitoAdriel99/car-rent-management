<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Order;


class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->input('brand') . '%');
        }

        if ($request->filled('model')) {
            $query->where('model', 'like', '%' . $request->input('model') . '%');
        }

        if ($request->filled('license_plate')) {
            $query->where('license_plate', 'like', '%' . $request->input('license_plate') . '%');
        }

        $cars = $query->where('isActive', 1)->get();
        return view('customer.home', compact('cars'));
    }

    public function order_list()
    {
        $user_id = auth()->id();
        $orders = Order::select('orders.*', 'cars.brand', 'cars.model', 'cars.license_plate', 'cars.image')
                        ->join('cars', 'orders.car_id', '=', 'cars.id')
                        ->where('orders.user_id', $user_id)
                        ->where('orders.status', 'Waiting')
                        ->orderBy('orders.created_at', 'desc')
                        ->get();

        return view('customer.order', compact('orders'));
    }

    public function order_return()
    {
        $user_id = auth()->id();

        $orders = Order::select('orders.*', 'cars.brand', 'cars.model', 'cars.license_plate', 'cars.image', 'users.name')
                        ->join('cars', 'orders.car_id', '=', 'cars.id')
                        ->join('users', 'orders.user_id', '=', 'users.id')
                        ->where('orders.user_id', $user_id)
                        ->whereIn('orders.status', ['Approve','Return'])
                        ->orderBy('orders.created_at', 'desc')
                        ->get();

        return view('customer.return', compact('orders'));
    }

    public function return_order($id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'Return';
        $order->save();

        return redirect()->back()->with('success', 'Request Returning car!');
    }

    public function history_order_cust()
    {
        $user_id = auth()->id();

        $orders = Order::select('orders.*', 'cars.brand', 'cars.model', 'cars.license_plate', 'cars.image', 'users.name')
                        ->join('cars', 'orders.car_id', '=', 'cars.id')
                        ->join('users', 'orders.user_id', '=', 'users.id')
                        ->where('orders.user_id', $user_id)
                        ->where('orders.status', 'Complete')
                        ->orderBy('orders.created_at', 'desc')
                        ->get();

        return view('customer.history', compact('orders'));
    }
}
