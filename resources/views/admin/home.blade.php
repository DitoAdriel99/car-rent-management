@extends('layouts.main')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">List Mobil</h1>

    <!-- Button to trigger modal -->
    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#addCarModal">
        Tambah Mobil
    </button>
    <!-- Search Bar -->
    <form action="{{ route('admin.index') }}" method="GET" class="mb-4">
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
                        <p class="card-text"><strong>Status:</strong> {{ $car->status ?: 'Available' }}</p>
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#updateCarModal{{ $car->id }}">View Details</a>
                        <form id="delete-car-form-{{ $car->id }}" action="{{ route('cars.delete', ['id' => $car->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <!-- Additional form elements or buttons if needed -->
                            <button type="submit" class="btn btn-danger delete-btn">Delete</button>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Update Car Modal -->
            <div class="modal fade" id="updateCarModal{{ $car->id }}" tabindex="-1" role="dialog" aria-labelledby="updateCarModalLabel{{ $car->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateCarModalLabel{{ $car->id }}">Update Car Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for updating a car -->
                            <form action="{{ route('cars.update', ['id' => $car->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Use PUT method for update -->
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <input type="text" class="form-control" id="brand" name="carBrand" value="{{ $car->brand }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <input type="text" class="form-control" id="model" name="carModel" value="{{ $car->model }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="license_plate">License Plate</label>
                                    <input type="text" class="form-control" id="license_plate" name="licensePlate" value="{{ $car->license_plate }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control-file" id="image" name="carImage">
                                </div>
                                <button type="submit" class="btn btn-primary">Update Car</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Update Car Modal -->
        @endforeach
    </div>

    <!-- Add Car Modal -->
    <div class="modal fade" id="addCarModal" tabindex="-1" role="dialog" aria-labelledby="addCarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCarModalLabel">Add New Car</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for adding a new car -->
                    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input type="text" class="form-control" id="brand" name="carBrand" required>
                        </div>
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" class="form-control" id="model" name="carModel" required>
                        </div>
                        <div class="form-group">
                            <label for="license_plate">License Plate</label>
                            <input type="text" class="form-control" id="license_plate" name="licensePlate" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control-file" id="image" name="carImage" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Car</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Add Car Modal -->
@endsection
