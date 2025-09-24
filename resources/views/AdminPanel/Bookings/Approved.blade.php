@extends('master')
@section('content')
<div class="page-inner">
    <div class="container mt-5">
    <h2 class="mb-4">Bookings Approved List</h2>

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
                <th>Member</th>
                <th>Total Price</th>
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
                <td>{{ $booking->members}}</td>
                <td>{{ $booking->package->hotel_total_price }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection
