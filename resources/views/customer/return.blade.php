@extends('layouts.customer')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">List Pemakaian</h1>

    <div class="row">
        @foreach($orders as $car)
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top" alt="{{ $car->brand }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->brand }} - {{ $car->model }}</h5>
                        <p class="card-text"><strong>Name:</strong> {{ $car->name }}</p>
                        <p class="card-text"><strong>License Plate:</strong> {{ $car->license_plate }}</p>
                        <p class="card-text"><strong>Request For</strong>
                        <p class="card-text"><strong>Start Date:</strong> {{ $car->start_date }}</p>
                        <p class="card-text"><strong>End Date:</strong> {{ $car->end_date }}</p>
                        <p class="card-text"><strong>Price:</strong> Rp{{ $car->price }}</p>
                        <p class="card-text"><strong>Status:</strong> {{ $car->status }}</p>
                        @if ($car->status == 'Approve')
                            <button class="btn btn-success complete-btn" onclick="event.preventDefault(); document.getElementById('return-order-form-{{ $car->id }}').submit();">Return</button>
                            <form id="return-order-form-{{ $car->id }}" action="{{ route('orders.return', ['id' => $car->id]) }}" method="GET" style="display: none;">
                                @csrf
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
