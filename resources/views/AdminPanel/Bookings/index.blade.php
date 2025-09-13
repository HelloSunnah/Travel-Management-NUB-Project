@extends('master')
@section('content')
<div class="page-inner">
    <div class="container mt-5">
    <h2 class="mb-4">Bookings List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Package</th>
                <th>Customer</th>
                <th>Email / Phone</th>
                <th>Booking Date</th>
                <th>Adults / Children</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>
                    <strong>{{ $booking->package->title }}</strong><br>
                    {{ Str::limit($booking->package->description,50) }}
                </td>
                <td>{{ $booking->customer_name }}</td>
                <td>{{ $booking->customer_email }}<br>{{ $booking->customer_phone }}</td>
                <td>{{ $booking->booking_date }}</td>
                <td>{{ $booking->adults }} / {{ $booking->children }}</td>
                <td>{{ $booking->package->hotel_total_price }}</td>
                <td>
                    @if($booking->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($booking->status == 'approved')
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </td>
                <td>
                    @if($booking->status == 'pending')
                        <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm">Cancel</button>
                        </form>
                    @else
                        <span class="text-muted">No actions</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection
