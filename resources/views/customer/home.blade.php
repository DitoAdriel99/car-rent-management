@extends('layouts.customer')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">List Mobil</h1>
    <!-- Search Bar -->
    <form action="{{ route('customer.index') }}" method="GET" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="searchBrand">Brand</label>
                <input type="text" class="form-control" id="searchBrand" name="brand" value="{{ request()->input('brand') }}" placeholder="Search by Brand">
            </div>
            <div class="form-group col-md-3">
                <label for="searchModel">Model</label>
                <input type="text" class="form-control" id="searchModel" name="model" value="{{ request()->input('model') }}" placeholder="Search by Model">
            </div>
            <div class="form-group col-md-3">
                <label for="searchLicensePlate">License Plate</label>
                <input type="text" class="form-control" id="searchLicensePlate" name="license_plate" value="{{ request()->input('license_plate') }}" placeholder="Search by License Plate">
            </div>
            <div class="form-group col-md-3">
                <label>&nbsp;</label><br>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <div class="row">
        @foreach($cars as $car)
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top" alt="{{ $car->brand }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->brand }} - {{ $car->model }}</h5>
                        <p class="card-text"><strong>License Plate:</strong> {{ $car->license_plate }}</p>
                        <form action="{{ route('cars.order', ['id' => $car->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" id="carId" name="carId" value="{{ $car->id }}">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="startDate" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="endDate" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Order</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
