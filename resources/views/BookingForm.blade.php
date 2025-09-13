@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="row g-4">
        <!-- Package Details Card -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <img src="{{ asset('storage/' . $package->image) }}" class="card-img-top rounded-top" alt="{{ $package->title }}">
                <div class="card-body">
                    <h2 class="card-title text-primary">{{ $package->title }}</h2>
                    <p class="card-text">{{ $package->description }}</p>
                    
                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item"><i class="fas fa-map-marker-alt me-2 text-danger"></i><strong>Destination:</strong> {{ $package->destination->name ?? 'N/A' }}</li>
                        <li class="list-group-item"><i class="fas fa-hotel me-2 text-info"></i><strong>Hotel:</strong> {{ $package->hotel->name ?? '' }}</li>
                        <li class="list-group-item"><i class="fas fa-moon me-2 text-warning"></i><strong>Nights:</strong> {{ $package->nights }}</li>
                        <li class="list-group-item"><i class="fas fa-calendar-alt me-2 text-success"></i><strong>Start:</strong> {{ $package->start_date }}</li>
                        <li class="list-group-item"><i class="fas fa-calendar-check me-2 text-success"></i><strong>End:</strong> {{ $package->end_date }}</li>
                        <li class="list-group-item">
                            <i class="fas fa-dollar-sign me-2 text-primary"></i>
                            <strong>Per Head Price:</strong> $<span id="perHeadPrice">{{ $package->per_head_price }}</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-calculator me-2 text-success"></i>
                            <strong>Total Price:</strong> $<span id="totalPrice">{{ $package->per_head_price }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Booking Form Card -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-success">Book Your Trip</h4>
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                        <input type="hidden" name="total_price" id="total_price_input" value="{{ $package->per_head_price }}">

                        <div class="mb-3">
                            <label class="form-label">Your Name</label>
                            <input class="form-control" name="customer_name" placeholder="John Doe" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input class="form-control" name="customer_email" type="email" placeholder="email@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input class="form-control" name="customer_phone" type="tel" placeholder="+8801XXXXXXXXX" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Travel Date</label>
                            <input class="form-control" name="booking_date" type="date" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Adults</label>
                            <input class="form-control person-input" id="adults" name="adults" type="number" value="1" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Note (optional)</label>
                            <textarea class="form-control" name="note" rows="3" placeholder="Any special requests?"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold">Confirm Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inline script for total price calculation -->
<script>
    const perHeadPrice = parseFloat('{{ $package->per_head_price }}');
    const adultsInput = document.getElementById('adults');
    const totalPriceSpan = document.getElementById('totalPrice');
    const totalPriceInput = document.getElementById('total_price_input');

    function calculateTotal() {
        const adults = parseInt(adultsInput.value) || 1;
        const total = adults * perHeadPrice;
        totalPriceSpan.textContent = total.toFixed(2);
        totalPriceInput.value = total.toFixed(2);
    }

    adultsInput.addEventListener('input', calculateTotal);
</script>
@endsection
