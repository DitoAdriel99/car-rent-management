@extends('layouts.main')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">History Order</h1>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Car Brand</th>
                                <th>Car Model</th>
                                <th>Plate</th>
                                <th>User</th>
                                <th>Driving License</th>
                                <th>Address</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->brand }}</td>
                                    <td>{{ $order->model }}</td>
                                    <td>{{ $order->license_plate }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->driving_license }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>{{ $order->start_date }}</td>
                                    <td>{{ $order->end_date }}</td>
                                    <td>{{ $order->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection

@section('scripts')

@endsection
