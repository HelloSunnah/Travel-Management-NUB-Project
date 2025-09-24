@extends('welcome')

@section('content')

    <section class="testimonials">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-success">✨ What Our Best Trip ✨</h2>
            <p class="text-muted">Hear from our happy customers and book your next trip with confidence!</p>
        </div>

        <div class="row g-4">
            <!-- Package Details -->
            <div class="col-lg-6">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                    <img src="{{ asset('storage/' . $package->image) }}"
                         class="card-img-top"
                         alt="{{ $package->title }}"
                         style="height: 250px; object-fit: cover;">

                    <div class="card-body p-4">
                        <h3 class="card-title text-primary fw-bold">{{ $package->title }}</h3>
                        <p class="text-muted">{{ $package->description }}</p>

                        <ul class="list-unstyled mt-3">
                            <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-danger"></i><strong>Destination:</strong> {{ $package->destination->name ?? 'N/A' }}</li>
                            <li class="mb-2"><i class="fas fa-hotel me-2 text-info"></i><strong>Hotel:</strong> {{ $package->hotel->name ?? 'N/A' }}</li>
                            <li class="mb-2"><i class="fas fa-moon me-2 text-warning"></i><strong>Nights:</strong> {{ $package->nights }}</li>
                            <li class="mb-2"><i class="fas fa-calendar-alt me-2 text-success"></i><strong>Start:</strong> {{ $package->start_date }}</li>
                            <li class="mb-2"><i class="fas fa-calendar-check me-2 text-success"></i><strong>End:</strong> {{ $package->end_date }}</li>
                            <li class="mb-2"><i class="fas fa-dollar-sign me-2 text-primary"></i><strong>Per Head Price:</strong> $<span id="perHeadPrice">{{ $package->per_head_price }}</span></li>
                            <li><i class="fas fa-calculator me-2 text-success"></i><strong>Total Price:</strong> $<span id="totalPrice">{{ $package->per_head_price }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="col-lg-6">
                <div class="card border-0 shadow rounded-4 h-100">
                    <div class="card-body p-4">
                        <h4 class="text-success fw-bold mb-4">Book Your Trip</h4>

                        <form action="{{ route('bookings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="package_id" value="{{ $package->id }}">
                            <input type="hidden" name="total_price" id="total_price_input" value="{{ $package->per_head_price }}">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Your Name</label>
                                <input class="form-control" name="customer_name" placeholder="Md. Hasan" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input class="form-control" name="customer_email" type="email" placeholder="email@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input class="form-control" name="customer_phone" type="tel" placeholder="+8801XXXXXXXXX" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Member</label>
                                <input class="form-control person-input" id="members" name="members" type="number" value="1" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Note (Optional)</label>
                                <textarea class="form-control" name="note" rows="3" placeholder="Any special requests?"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100 fw-bold py-2">✅ Confirm Booking</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script for total price calculation -->
<script>
    const perHeadPrice = parseFloat('{{ $package->per_head_price }}');
    const membersInput = document.getElementById('members');
    const totalPriceSpan = document.getElementById('totalPrice');
    const totalPriceInput = document.getElementById('total_price_input');

    function calculateTotal() {
        const members = parseInt(membersInput.value) || 1;
        const total = members * perHeadPrice;
        totalPriceSpan.textContent = total.toFixed(2);
        totalPriceInput.value = total.toFixed(2);
    }

    membersInput.addEventListener('input', calculateTotal);

    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>
@endsection
