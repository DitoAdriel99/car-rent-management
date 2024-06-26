<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Order;
use Carbon\Carbon;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        return view('admin.home', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function order_waiting()
    {
        $orders = Order::select('orders.*', 'cars.brand', 'cars.model', 'cars.license_plate', 'cars.image', 'users.name')
                        ->join('cars', 'orders.car_id', '=', 'cars.id')
                        ->join('users', 'orders.user_id', '=', 'users.id')
                        ->where('orders.status', '=', 'Waiting')
                        ->orderBy('orders.created_at', 'desc')
                        ->get();

        return view('admin.order', compact('orders'));
    }

    public function order_ongoing()
    {
        $orders = Order::select('orders.*', 'cars.brand', 'cars.model', 'cars.license_plate', 'cars.image', 'users.name')
                        ->join('cars', 'orders.car_id', '=', 'cars.id')
                        ->join('users', 'orders.user_id', '=', 'users.id')
                        ->whereIn('orders.status', ['Approve','Return'])
                        ->orderBy('orders.created_at', 'desc')
                        ->get();

        return view('admin.approve', compact('orders'));
    }

    public function fetchProfile($id)
    {
        $order = Order::select('orders.*', 'users.name', 'users.address', 'users.phone', 'users.driving_license')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->where('orders.id', '=', $id)
                ->first();

        $profile = [
            'name' => $order->name,
            'address' => $order->address,
            'phone' => $order->phone,
            'driving_license' => $order->driving_license,
        ];
        return response()->json($profile);
    }

    public function accept_order($id)
    {
        $order = Order::findOrFail($id);

        $existingOrders = Order::where('car_id', $order->car_id)
                            ->where('status', 'Approve')
                            ->get();

        foreach ($existingOrders as $existingOrder) {
            if ($this->ordersOverlap($existingOrder, $order)) {
                return redirect()->back()->with('error', 'Cannot approve order. Car is still in use within the selected date range.');
            }
        }

        $order->status = 'Approve';
        $order->save();

        return redirect()->back()->with('success', 'Order approved successfully!');
    }

    private function ordersOverlap($order1, $order2)
    {
        $start1 = Carbon::parse($order1->start_date);
        $end1 = Carbon::parse($order1->end_date);
        $start2 = Carbon::parse($order2->start_date);
        $end2 = Carbon::parse($order2->end_date);

        return $start1 < $end2 && $end1 > $start2;
    }

    public function reject_order($id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'Reject';
        $order->save();

        return redirect()->back()->with('success', 'Order rejected!');
    }

    public function complete_order($id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'Complete';
        $order->save();

        return redirect()->back()->with('success', 'Order Complete!');
    }

    public function history_order()
    {
        $orders = Order::select('orders.*', 'cars.brand','cars.model','cars.license_plate','users.*')
                        ->join('cars', 'orders.car_id', '=', 'cars.id')
                        ->join('users', 'orders.user_id', '=', 'users.id')
                        ->whereIn('orders.status', ['Complete', 'Reject'])
                        ->orderBy('orders.created_at', 'asc')
                        ->get();

        return view('admin.history', compact('orders'));
    }


}
