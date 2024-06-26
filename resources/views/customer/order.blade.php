@extends('layouts.customer')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">List Order</h1>

    <div class="row">
        @foreach($orders as $car)
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top" alt="{{ $car->brand }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->brand }} - {{ $car->model }}</h5>
                        <p class="card-text"><strong>License Plate:</strong> {{ $car->license_plate }}</p>
                        <p class="card-text"><strong>Request For</strong>
                        <p class="card-text"><strong>Start Date:</strong> {{ $car->start_date }}</p>
                        <p class="card-text"><strong>End Date:</strong> {{ $car->end_date }}</p>
                        <p class="card-text"><strong>Price:</strong> Rp{{ $car->price }}</p>
                        <p class="card-text"><strong>Status:</strong> {{ $car->status }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
