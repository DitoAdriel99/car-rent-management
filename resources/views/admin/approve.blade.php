@extends('layouts.main')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">List Order Approve Customer</h1>

    <div class="row">
        @foreach($orders as $order)
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <img src="{{ asset('storage/' . $order->image) }}" class="card-img-top" alt="{{ $order->brand }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $order->brand }} - {{ $order->model }}</h5>
                        <p class="card-text"><strong>License Plate:</strong> {{ $order->license_plate }}</p>
                        <p class="card-text"><strong>Start Date:</strong> {{ $order->start_date }}</p>
                        <p class="card-text"><strong>End Date:</strong> {{ $order->end_date }}</p>
                        <p class="card-text"><strong>Price:</strong> Rp{{ $order->price }}</p>
                        <p class="card-text"><strong>Status:</strong> {{ $order->status }}</p>
                        @if ($order->status == 'Return')
                        <button class="btn btn-success complete-btn" onclick="event.preventDefault(); document.getElementById('complete-order-form-{{ $order->id }}').submit();">Selesai</button>
                        <form id="complete-order-form-{{ $order->id }}" action="{{ route('orders.complete', ['id' => $order->id]) }}" method="GET" style="display: none;">
                            @csrf
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')

@endsection
