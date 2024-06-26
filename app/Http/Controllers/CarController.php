<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */

      /**
     * Store a newly created car in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        //
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
        $request->validate([
            'carBrand' => 'required|string|max:255',
            'carModel' => 'required|string|max:255',
            'licensePlate' => 'required|string|max:20|unique:cars,license_plate',
            'carImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file if provided
        ]);

       // Handle file upload using storeImage() method from Car model instance
        $imagePath = null;
        if ($request->hasFile('carImage')) {
        $carImage = $request->file('carImage');
        $car = new Car();
        $imagePath = $car->storeImage($carImage);
        }


        // Create a new Car instance
        $car = new Car();
        $car->brand = $request->input('carBrand');
        $car->model = $request->input('carModel');
        $car->license_plate = $request->input('licensePlate');
        $car->image = $imagePath; // Store image path in database

        $car->save();

        return redirect()->route('admin.index')->with('success', 'Car created successfully!');
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'carBrand' => 'required|string|max:255',
            'carModel' => 'required|string|max:255',
            'licensePlate' => [
                'required',
                'string',
                'max:20',
                Rule::unique('cars', 'license_plate')->ignore($id),
            ],
            'carImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the car by ID
        $car = Car::findOrFail($id);

        // Handle file upload using storeImage() method from Car model instance
        if ($request->hasFile('carImage')) {
            $carImage = $request->file('carImage');
            $imagePath = $car->storeImage($carImage);
            $car->image = $imagePath;
        }

        // Update car details
        $car->brand = $request->input('carBrand');
        $car->model = $request->input('carModel');
        $car->license_plate = $request->input('licensePlate');

        // Save the updated car
        $car->save();

        return redirect()->route('admin.index')->with('success', 'Car updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::findOrFail($id);

        $car->isActive = 0;
        $car->save();

        return redirect()->back()->with('success', 'Car deleted!');
    }

    public function order(Request $request, string $id)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $startDate = Carbon::parse($request->input('startDate'));
        $endDate = Carbon::parse($request->input('endDate'));

         // Calculate the number of days
        $days = $startDate->diffInDays($endDate) + 1; // Include the start date

        // Calculate the price (300,000 per day)
        $pricePerDay = 300000;
        $totalPrice = $days * $pricePerDay;

        $order = new Order();
        $order->user_id = auth()->id();
        $order->car_id = $id;
        $order->start_date = $startDate;
        $order->end_date = $endDate;
        $order->status = 'Waiting';
        $order->price = $totalPrice;
        $order->save();

        return redirect()->route('customer.index')->with('success', 'Car ordered successfully!');

    }
}
