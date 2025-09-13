@extends('master')
@section('content')
<div class="container py-5">
    <h2 class="mb-5 text-primary fw-bold">Travel Packages Management</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-5 p-4 border-0 rounded-4">
        <h4 class="mb-4">{{ isset($package) ? 'Edit Package' : 'Create Package' }}</h4>
        <form action="{{ isset($package) ? route('packages.update', $package) : route('packages.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($package)) @method('PUT') @endif

            {{-- Package Title --}}
            <div class="mb-3">
                <label for="title" class="form-label fw-bold">Package Title</label>
                <input type="text" id="title" name="title" class="form-control rounded-3"
                       value="{{ old('title', $package->title ?? '') }}" required>
            </div>
                <div class="col-md-3">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <input type="text" name="description" id="description" class="form-control rounded-3"
                           value="{{ old('description', $package->description ?? "") }}" required>
                </div>
            {{-- Destination & Image --}}
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="destination_id" class="form-label fw-bold">Destination</label>
                    <select id="destination_id" name="destination_id" class="form-select rounded-3" required>
                        <option value="">Select Destination</option>
                        @foreach($destinations as $dest)
                            <option value="{{ $dest->id }}"
                                {{ (old('destination_id', $package->destination_id ?? '') == $dest->id) ? 'selected' : '' }}>
                                {{ $dest->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="image" class="form-label fw-bold">Package Image</label>
                    <input type="file" id="image" name="image" class="form-control rounded-3">
                    @if(isset($package) && $package->image)
                        <div class="mt-2">
                            <img src="{{ asset('uploads/packages/' . $package->image) }}"
                                 alt="Package Image" class="img-thumbnail rounded-3" width="200">
                        </div>
                    @endif
                </div>
            </div>

            {{-- Hotel & Room --}}
            <div class="row g-4 mt-3">
                <div class="col-md-6">
                    <label for="hotel-select" class="form-label fw-bold">Hotel</label>
                    <select name="hotel_id" id="hotel-select" class="form-select rounded-3" required>
                        <option value="">Select Hotel</option>
                        @foreach($hotels as $hotel)
                            <option value="{{ $hotel->id }}"
                                {{ (old('hotel_id', $package->hotel_id ?? '') == $hotel->id) ? 'selected' : '' }}>
                                {{ $hotel->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="room-select" class="form-label fw-bold">Room</label>
                    <select name="room_id" id="room-select" class="form-select rounded-3" required></select>
                </div>

                <div class="col-md-3">
                    <label for="nights" class="form-label fw-bold">Nights</label>
                    <input type="number" name="nights" id="nights" class="form-control rounded-3" min="1"
                           value="{{ old('nights', $package->nights ?? 1) }}" required>
                </div>
                <div class="col-md-3">
                    <label for="hotel_total_price" class="form-label fw-bold">Hotel Total ($)</label>
                    <input type="number" name="hotel_total_price" id="hotel_total_price" class="form-control rounded-3" readonly>
                </div>
            </div>

            {{-- Food Menus --}}
            <hr class="my-4">
            <h5 class="fw-bold mb-3 text-secondary">Food Menus</h5>
            <div class="row g-3 foods-container"></div>

            {{-- Prices --}}
            <hr class="my-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <label for="base_price" class="form-label fw-bold">Base Price ($)</label>
                    <input type="number" name="base_price" id="base_price" class="form-control rounded-3" step="0.01"
                           value="{{ old('base_price', $package->base_price ?? 0) }}">
                </div>
                <div class="col-md-4">
                    <label for="extra_cost" class="form-label fw-bold">Extra Cost ($)</label>
                    <input type="number" name="extra_cost" id="extra_cost" class="form-control rounded-3" step="0.01"
                           value="{{ old('extra_cost', $package->extra_cost ?? 0) }}">
                </div>
                <div class="col-md-4">
                    <label for="transport_cost" class="form-label fw-bold">Transport Cost ($)</label>
                    <input type="number" name="transport_cost" id="transport_cost" class="form-control rounded-3" step="0.01"
                           value="{{ old('transport_cost', $package->transport_cost ?? 0) }}">
                </div>
            </div>

            {{-- Dates --}}
            <hr class="my-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="start_date" class="form-label fw-bold">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control rounded-3"
                           value="{{ old('start_date', $package->start_date ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="end_date" class="form-label fw-bold">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control rounded-3"
                           value="{{ old('end_date', $package->end_date ?? '') }}" required>
                </div>
            </div>

            {{-- Grand Total --}}
            <div class="text-end mt-4">
                <label class="form-label fw-bold">Grand Total ($)</label>
                <input type="text" id="grand_total"
                       class="form-control d-inline-block w-auto text-end fw-bold bg-light border-0 fs-5 rounded-3"
                       readonly>
            </div>

            <button type="submit" class="btn btn-success mt-3 rounded-3">
                {{ isset($package) ? 'Update Package' : 'Create Package' }}
            </button>
        </form>
    </div>

    {{-- All Packages Table --}}
    <div class="card shadow-sm p-4 border-0 rounded-4">
        <h4 class="mb-4 text-primary">All Packages</h4>
        @if($packages->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Destination</th>
                            <th>Hotel</th>
                            <th>Room</th>
                            <th>Nights</th>
                            <th>Hotel Total ($)</th>
                            <th>Foods</th>
                            <th>Base</th>
                            <th>Extra</th>
                            <th>Transport</th>
                            <th>Grand Total ($)</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $key => $p)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if($p->image)
                                    <a target="_blank">
                                        <img src="{{ asset('storage/' . $p->image) }}" alt="Package Image" width="100">

                                    </a>
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $p->title }}</td>
                            <td>{{ $p->description }}</td>
                            <td>{{ $p->destination->name ?? '' }}</td>
                            <td>{{ $p->hotel->name ?? '' }}</td>
                            <td>{{ $p->room->room_type ?? '' }}</td>
                            <td>{{ $p->nights }}</td>
                            <td>${{ number_format($p->hotel_total_price ?? 0, 2) }}</td>
                            <td>
                                @foreach($p->foods as $food)
                                    <span class="badge bg-info text-dark">
                                        {{ $food->name }} x{{ $food->pivot->quantity }}
                                    </span>
                                @endforeach
                            </td>
                            <td>${{ number_format($p->base_price ?? 0, 2) }}</td>
                            <td>${{ number_format($p->extra_cost ?? 0, 2) }}</td>
                            <td>${{ number_format($p->transport_cost ?? 0, 2) }}</td>
                            <td>
                                ${{ number_format(
                                    ($p->hotel_total_price ?? 0)
                                    + ($p->foods->sum(fn($f) => $f->pivot->price * $f->pivot->quantity))
                                    + ($p->base_price ?? 0)
                                    + ($p->extra_cost ?? 0)
                                    + ($p->transport_cost ?? 0), 2) }}
                            </td>
                            <td>{{ $p->start_date }}</td>
                            <td>{{ $p->end_date }}</td>
                            <td>
                                <a href="{{ route('packages.edit', $p) }}" class="btn btn-sm btn-primary rounded-3">Edit</a>
                                <form action="{{ route('packages.destroy', $p) }}" method="POST"
                                      class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-3">Delete</button>
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


<script>
    const destinationSelect = document.getElementById('destination_id');
    const hotelSelect = document.getElementById('hotel-select');
    const roomSelect = document.getElementById('room-select');
    const nightsInput = document.getElementById('nights');
    const hotelPriceInput = document.getElementById('hotel_total_price');
    const foodsContainer = document.querySelector('.foods-container');
    const basePriceInput = document.getElementById('base_price');
    const extraInput = document.getElementById('extra_cost');
    const transportInput = document.getElementById('transport_cost');
    const grandTotalInput = document.getElementById('grand_total');

    // --- Update Hotel Price ---
    function updateHotelPrice() {
        const roomOption = roomSelect.selectedOptions[0];
        if(roomOption && nightsInput.value){
            const roomPrice = parseFloat(roomOption.dataset.price) || 0;
            hotelPriceInput.value = (roomPrice * parseInt(nightsInput.value)).toFixed(2);
        } else {
            hotelPriceInput.value = 0;
        }
        updateGrandTotal();
    }

    // --- Fetch Rooms ---
    hotelSelect.addEventListener('change', function () {
        fetch(`/hotels/${this.value}/rooms`)
            .then(res => res.json())
            .then(data => {
                roomSelect.innerHTML = '';
                data.forEach(room => {
                    const opt = document.createElement('option');
                    opt.value = room.id;
                    opt.dataset.price = room.price_per_night;
                    opt.text = `${room.room_type} - $${room.price_per_night}`;
                    roomSelect.appendChild(opt);
                });
                updateHotelPrice();
            });
    });
    roomSelect.addEventListener('change', updateHotelPrice);
    nightsInput.addEventListener('input', updateHotelPrice);

    // --- Fetch Hotels + Foods on Destination change ---
    destinationSelect.addEventListener('change', function () {
        // Hotels
        fetch(`/destinations/${this.value}/hotels`)
            .then(res => res.json())
            .then(data => {
                hotelSelect.innerHTML = '<option value="">Select Hotel</option>';
                roomSelect.innerHTML = '';
                data.forEach(hotel => {
                    const opt = document.createElement('option');
                    opt.value = hotel.id;
                    opt.text = hotel.name;
                    hotelSelect.appendChild(opt);
                });
            });

        // Foods
        fetch(`/destinations/${this.value}/foods`)
            .then(res => res.json())
            .then(data => {
                foodsContainer.innerHTML = '';
                data.forEach(food => {
                    const div = document.createElement('div');
                    div.classList.add('col-md-6','col-lg-4');
                    div.innerHTML = `
                        <div class="card shadow-sm border-0 h-100 food-card">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <label class="fw-semibold mb-2">
                                    <input type="checkbox" class="form-check-input me-2 food-checkbox" data-price="${food.price}" data-id="${food.id}">
                                    ${food.name}
                                </label>
                                <small class="text-muted mb-2">${food.menu_items}</small>
                                <div class="d-flex align-items-center gap-2 mt-auto">
                                    <input type="number" class="form-control form-control-sm food-qty" data-id="${food.id}" min="1" value="1" style="width:70px;" disabled>
                                    <input type="number" class="form-control form-control-sm food-total text-end" data-id="${food.id}" step="0.01" value="${food.price}" style="width:90px;" disabled>
                                </div>
                                <span class="badge bg-primary mt-2">$${food.price}</span>
                            </div>
                        </div>
                    `;
                    foodsContainer.appendChild(div);
                });
                attachFoodEvents();
            });
    });
    function attachFoodEvents() {
        document.querySelectorAll('.food-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                const id = this.dataset.id;
                const qtyInput = document.querySelector(`.food-qty[data-id="${id}"]`);
                const totalInput = document.querySelector(`.food-total[data-id="${id}"]`);
                if (this.checked) {
                    qtyInput.disabled = false;
                    totalInput.disabled = false;
                } else {
                    qtyInput.disabled = true;
                    totalInput.disabled = true;
                    totalInput.value = 0;
                }
                updateGrandTotal();
            });
        });
        document.querySelectorAll('.food-qty').forEach(qty => {
            qty.addEventListener('input', function() {
                const id = this.dataset.id;
                const price = parseFloat(document.querySelector(`.food-checkbox[data-id="${id}"]`).dataset.price);
                const totalInput = document.querySelector(`.food-total[data-id="${id}"]`);
                totalInput.value = (price * this.value).toFixed(2);
                updateGrandTotal();
            });
        });
    }

    // --- Grand Total ---
    function updateGrandTotal() {
        let total = parseFloat(hotelPriceInput.value) || 0;

        document.querySelectorAll('.food-checkbox:checked').forEach(cb => {
            const id = cb.dataset.id;
            const foodTotal = parseFloat(document.querySelector(`.food-total[data-id="${id}"]`).value) || 0;
            total += foodTotal;
        });

        total += parseFloat(basePriceInput.value) || 0;
        total += parseFloat(extraInput.value) || 0;
        total += parseFloat(transportInput.value) || 0;

        grandTotalInput.value = total.toFixed(2);
    }

    basePriceInput.addEventListener('input', updateGrandTotal);
    extraInput.addEventListener('input', updateGrandTotal);
    transportInput.addEventListener('input', updateGrandTotal);

    // Init
    updateHotelPrice();
    updateGrandTotal();
</script>

<style>
.food-card {
    transition: transform .3s, box-shadow .3s;
    border-radius: 1rem;
}
.food-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}
.food-checkbox:checked ~ .fw-semibold {
    color: #0d6efd;
}
.card .form-control {
    box-shadow: none;
}
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
</style>
@endsection
