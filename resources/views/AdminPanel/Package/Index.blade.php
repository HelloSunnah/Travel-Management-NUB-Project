@extends('master')
@section('content')
<div class="container py-5">

    <h2 class="mb-5 text-primary fw-bold text-center">
        {{ isset($package) ? '✏️ Edit Travel Package' : '➕ Create New Travel Package' }}
    </h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="card shadow-lg border-0 rounded-4 mb-5">
        <div class="card-header bg-primary text-white fw-bold rounded-top-4">
            {{ isset($package) ? '✏️ Edit Package' : '➕ Create Package' }}
        </div>
        <div class="card-body p-4">
            <form
                action="{{ isset($package) ? route('packages.update', $package) : route('packages.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="row g-4"
            >
                @csrf
                @if(isset($package)) @method('PUT') @endif

                {{-- Package Title --}}
                <div class="col-md-6">
                    <label for="title" class="form-label fw-bold">Package Title</label>
                    <input type="text" id="title" name="title" class="form-control rounded-3 shadow-sm"
                        value="{{ $package->title ?? old('title') }}" required>
                </div>

                {{-- Description --}}
                <div class="col-md-6">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <input type="text" name="description" id="description" class="form-control rounded-3 shadow-sm"
                        value="{{ $package->description ?? old('description') }}">
                </div>

                {{-- Destination --}}
                <div class="col-md-6">
                    <label for="destination_id" class="form-label fw-bold">Destination</label>
                    <select id="destination_id" name="destination_id" class="form-select rounded-3 shadow-sm" required>
                        <option value="">Select Destination</option>
                        @foreach ($destinations as $dest)
                            <option value="{{ $dest->id }}"
                                {{ (isset($package) && $package->destination_id == $dest->id) ? 'selected' : '' }}>
                                {{ $dest->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Image --}}
                <div class="col-md-6">
                    <label for="image" class="form-label fw-bold">Package Image</label>
                    <input type="file" id="image" name="image" class="form-control rounded-3 shadow-sm">
                    @if(isset($package) && $package->image)
                        <img src="{{ asset('storage/'.$package->image) }}" width="100" class="mt-2 rounded shadow-sm">
                    @endif
                </div>

                {{-- Hotel & Room --}}
                <div class="col-md-6">
                    <label for="hotel-select" class="form-label fw-bold">Hotel</label>
                    <select name="hotel_id" id="hotel-select" class="form-select rounded-3 shadow-sm" required>
                        <option value="">Select Hotel</option>
                        @foreach ($hotels as $hotel)
                            <option value="{{ $hotel->id }}"
                                {{ (isset($package) && $package->hotel_id == $hotel->id) ? 'selected' : '' }}>
                                {{ $hotel->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="room-select" class="form-label fw-bold">Room</label>
                    <select name="room_id" id="room-select" class="form-select rounded-3 shadow-sm" required>
                        @if(isset($package) && $package->room)
                            <option value="{{ $package->room->id }}" data-price="{{ $package->room->price_per_night }}" selected>
                                {{ $package->room->room_type }} - ${{ $package->room->price_per_person }}
                            </option>
                        @endif
                    </select>
                </div>

                {{-- Nights & Hotel Price --}}
                <div class="col-md-3">
                    <label for="nights" class="form-label fw-bold">Nights</label>
                    <input type="number" name="nights" id="nights" class="form-control rounded-3 shadow-sm" min="1"
                        value="{{ $package->nights ?? 1 }}" required>
                </div>
                <div class="col-md-3">
                    <label for="price_per_person" class="form-label fw-bold">Hotel Per Person($)</label>
                    <input type="number" name="price_per_person" id="price_per_person" class="form-control rounded-3 shadow-sm bg-light" readonly
                        value="{{ $package->price_per_person ?? 0 }}">
                </div>

                {{-- Foods --}}
                <div class="col-12">
                    <hr>
                    <h5 class="fw-bold text-secondary">🍽 Food Menus</h5>
                    <div class="row g-3 foods-container">
                        {{-- Foods will be dynamically loaded via JS --}}
                    </div>
                </div>

                {{-- Pricing --}}
                <div class="col-12">
                    <hr>
                    <h5 class="fw-bold text-secondary">💲 Pricing</h5>
                </div>
                <div class="col-md-4">
                    <label for="base_price" class="form-label fw-bold">Base Price ($)</label>
                    <input type="number" name="base_price" id="base_price" class="form-control rounded-3 shadow-sm" step="0.01"
                        value="{{ $package->base_price ?? 0 }}">
                </div>
                <div class="col-md-4">
                    <label for="extra_cost" class="form-label fw-bold">Extra Cost ($)</label>
                    <input type="number" name="extra_cost" id="extra_cost" class="form-control rounded-3 shadow-sm" step="0.01"
                        value="{{ $package->extra_cost ?? 0 }}">
                </div>
                <div class="col-md-4">
                    <label for="transport_cost" class="form-label fw-bold">Transport Cost ($)</label>
                    <input type="number" name="transport_cost" id="transport_cost" class="form-control rounded-3 shadow-sm" step="0.01"
                        value="{{ $package->transport_cost ?? 0 }}">
                </div>

                {{-- Dates --}}
                <div class="col-12">
                    <hr>
                    <h5 class="fw-bold text-secondary">📅 Travel Dates</h5>
                </div>
                <div class="col-md-6">
                    <label for="start_date" class="form-label fw-bold">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control rounded-3 shadow-sm"
                        value="{{ $package->start_date ?? '' }}" required>
                </div>
                <div class="col-md-6">
                    <label for="end_date" class="form-label fw-bold">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control rounded-3 shadow-sm"
                        value="{{ $package->end_date ?? '' }}" required>
                </div>

                {{-- Grand Total --}}
                <div class="col-12 text-end mt-4">
                    <label class="form-label fw-bold me-2">Grand Total ($)</label>
                    <input type="text" id="grand_total" class="form-control d-inline-block w-auto text-end fw-bold bg-light border-0 fs-5 rounded-3 shadow-sm" readonly
                        value="{{ $package->grand_total ?? 0 }}">
                </div>

                {{-- Submit --}}
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-success px-4 py-2 rounded-3 shadow-sm">
                        {{ isset($package) ? '✅ Update Package' : '✅ Create Package' }}
                    </button>
                </div>

            </form>
        </div>
    </div>

      {{-- Packages Table --}}
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-dark text-white fw-bold rounded-top-4">
                📦 All Packages
            </div>
            <div class="card-body">
                @if ($packages->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center shadow-sm">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Destination</th>
                                    <th>Hotel</th>
                                    <th>Room</th>
                                    <th>Nights</th>
                                    <th>Hotel Per Person</th>
                                    <th>Foods</th>
                                    <th>Base</th>
                                    <th>Extra</th>
                                    <th>Transport</th>
                                    <th>Grand Total</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($packages as $key => $p)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if ($p->image)
                                                <img src="{{ asset('storage/' . $p->image) }}" alt="Package Image"
                                                    width="80" class="rounded shadow-sm">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold">{{ $p->title }}</td>
                                        <td>{{ $p->description }}</td>
                                        <td><span class="badge bg-info text-dark">{{ $p->destination->name ?? '' }}</span>
                                        </td>
                                        <td>{{ $p->hotel->name ?? '' }}</td>
                                        <td>{{ $p->room->room_type ?? '' }}</td>
                                        <td>{{ $p->nights }}</td>
                                        <td>${{ number_format($p->price_per_person ?? 0, 2) }}</td>
                                        <td>
                                            @foreach ($p->foods as $food)
                                                <span class="badge bg-warning text-dark">
                                                    {{ $food->name }} x{{ $food->pivot->quantity }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td>${{ number_format($p->base_price ?? 0, 2) }}</td>
                                        <td>${{ number_format($p->extra_cost ?? 0, 2) }}</td>
                                        <td>${{ number_format($p->transport_cost ?? 0, 2) }}</td>
                                        <td class="fw-bold text-success">
                                            ${{ number_format(
                                                ($p->price_per_person ?? 0) +
                                                    $p->foods->sum(fn($f) => $f->pivot->price * $f->pivot->quantity) +
                                                    ($p->base_price ?? 0) +
                                                    ($p->extra_cost ?? 0) +
                                                    ($p->transport_cost ?? 0),
                                                2,
                                            ) }}
                                        </td>
                                        <td>{{ $p->start_date }}</td>
                                        <td>{{ $p->end_date }}</td>
                                        <td>
                                            <a href="{{ route('packages.edit', $p) }}"
                                                class="btn btn-sm btn-outline-primary rounded-3">Edit</a>
                                            <form action="{{ route('packages.destroy', $p) }}" method="POST"
                                                class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger rounded-3">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No packages found.</p>
                @endif
            </div>
        </div>

</div>
<script>
    const hotelSelect = document.getElementById('hotel-select');
    const roomSelect = document.getElementById('room-select');
    const nightsInput = document.getElementById('nights');
    const hotelPriceInput = document.getElementById('price_per_person');
    const foodsContainer = document.querySelector('.foods-container');
    const basePriceInput = document.getElementById('base_price');
    const extraInput = document.getElementById('extra_cost');
    const transportInput = document.getElementById('transport_cost');
    const grandTotalInput = document.getElementById('grand_total');

    // Populate rooms based on hotel
    function populateRooms(hotelId) {
        if (!hotelId) return;
        fetch(`/hotels/${hotelId}/rooms`)
            .then(res => res.json())
            .then(data => {
                roomSelect.innerHTML = '';
                data.forEach(room => {
                    const opt = document.createElement('option');
                    opt.value = room.id;
                    opt.dataset.pricePerPerson = room.price_per_person; // store per person price
                    opt.text = `${room.room_type} - $${room.price_per_person}`;
                    roomSelect.appendChild(opt);
                });
                updateHotelPrice();
            });
    }

    // Update hotel per person price
    function updateHotelPrice() {
        const roomOption = roomSelect.selectedOptions[0];
        if (roomOption) {
            const pricePerPerson = parseFloat(roomOption.dataset.pricePerPerson) || 0;
            hotelPriceInput.value = pricePerPerson.toFixed(2); // show per person price
        } else {
            hotelPriceInput.value = 0;
        }
        updateGrandTotal();
    }

    // Update grand total
    function updateGrandTotal() {
        let total = parseFloat(hotelPriceInput.value) || 0;

        // Add food totals dynamically if any
        document.querySelectorAll('.food-total').forEach(ft => {
            total += parseFloat(ft.value) || 0;
        });

        // Add other costs
        total += parseFloat(basePriceInput.value) || 0;
        total += parseFloat(extraInput.value) || 0;
        total += parseFloat(transportInput.value) || 0;

        grandTotalInput.value = total.toFixed(2);
    }

    // Event listeners
    hotelSelect.addEventListener('change', function() { populateRooms(this.value); });
    roomSelect.addEventListener('change', updateHotelPrice);
    nightsInput.addEventListener('input', updateGrandTotal); // nights don't affect per person price but can affect grand total if needed
    basePriceInput.addEventListener('input', updateGrandTotal);
    extraInput.addEventListener('input', updateGrandTotal);
    transportInput.addEventListener('input', updateGrandTotal);

    // On page load: if hotel & room are preselected
    document.addEventListener('DOMContentLoaded', function() {
        if (hotelSelect.value) populateRooms(hotelSelect.value);
        updateGrandTotal();
    });
</script>
@endsection





