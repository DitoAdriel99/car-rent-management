@extends('layouts.main')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">List Order Customer</h1>

    <div class="row">
        @foreach($orders as $order)
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <img src="{{ asset('storage/' . $order->image) }}" class="card-img-top" alt="{{ $order->brand }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $order->brand }} - {{ $order->model }}</h5>
                        <p class="card-text"><strong>Customer:</strong> {{ $order->name }}</p>
                        <p class="card-text"><strong>License Plate:</strong> {{ $order->license_plate }}</p>
                        <p class="card-text"><strong>Start Date:</strong> {{ $order->start_date }}</p>
                        <p class="card-text"><strong>End Date:</strong> {{ $order->end_date }}</p>
                        <p class="card-text"><strong>Price:</strong> Rp{{ $order->price }}</p>
                        <p class="card-text"><strong>Status:</strong> {{ $order->status }}</p>
                        <button class="btn btn-primary order-btn" data-toggle="modal" onclick="fetchProfile('{{ $order->id }}')" data-target="#penyewa" data-order-id="{{ $order->id }}">Penyewa</button>
                        <button class="btn btn-success terima-btn" onclick="event.preventDefault(); document.getElementById('accept-order-form-{{ $order->id }}').submit();">Terima</button>
                        <form id="accept-order-form-{{ $order->id }}" action="{{ route('orders.accept', ['id' => $order->id]) }}" method="GET" style="display: none;">
                            @csrf
                        </form>
                        <button class="btn btn-danger reject-btn" onclick="event.preventDefault(); document.getElementById('reject-order-form-{{ $order->id }}').submit();">Tolak</button>
                        <form id="reject-order-form-{{ $order->id }}" action="{{ route('orders.reject', ['id' => $order->id]) }}" method="GET" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal for User Profile -->
    <div class="modal fade" id="penyewa" tabindex="-1" role="dialog" aria-labelledby="penyewaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penyewaLabel">Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="penyewa-profile">
                </div>
            </div>
        </div>
    </div>

    <script>
    function fetchProfile(orderId) {
        $.ajax({
            url: '/orders/' + orderId + '/profile',
            type: 'GET',
            success: function(response) {
                $('#penyewa-profile').html(`
                    <p><strong>Name:</strong> ${response.name}</p>
                    <p><strong>Address:</strong> ${response.address}</p>
                    <p><strong>Phone:</strong> ${response.phone}</p>
                    <p><strong>Driving License:</strong> ${response.driving_license}</p>
                    <!-- Add more fields as needed -->
                `);
                $('#penyewa').modal('show');
            },
            error: function(error) {
                console.error('Error fetching profile:', error);
            }
        });
    }
</script>
@endsection

@section('scripts')

@endsection
