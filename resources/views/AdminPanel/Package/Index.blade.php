@extends('master')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Travel Packages Management</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Package Form --}}
    <div class="card mb-5 p-4">
        <h4 class="mb-3">{{ isset($package) ? 'Edit Package' : 'Create Package' }}</h4>
        <form action="{{ isset($package) ? route('packages.update', $package) : route('packages.store') }}" method="POST">
            @csrf
            @if(isset($package)) @method('PUT') @endif

            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Package Title</label>
                <input type="text" id="title" name="title" class="form-control"
                       value="{{ old('title', $package->title ?? '') }}" required>
            </div>

            {{-- Destination --}}
            <div class="mb-3">
                <label for="destination_id" class="form-label">Destination</label>
                <select id="destination_id" name="destination_id" class="form-select" required>
                    <option value="">Select Destination</option>
                    @foreach($destinations as $dest)
                        <option value="{{ $dest->id }}" {{ (old('destination_id', $package->destination_id ?? '') == $dest->id) ? 'selected' : '' }}>
                            {{ $dest->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Foods --}}
            <h5 class="mt-3">Food Menus</h5>
            <div class="row g-2 foods-container"></div>

            {{-- Hotel --}}
            <div class="mb-3 mt-3">
                <label for="hotel-select" class="form-label">Hotel</label>
                <select name="hotel_id" id="hotel-select" class="form-select" required>
                    <option value="">Select Hotel</option>
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}" {{ (old('hotel_id', $package->hotel_id ?? '') == $hotel->id) ? 'selected' : '' }}>
                            {{ $hotel->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Room --}}
            <div class="mb-3">
                <label for="room-select" class="form-label">Room</label>
                <select name="room_id" id="room-select" class="form-select" required></select>
            </div>

            {{-- Nights --}}
            <div class="mb-3">
                <label for="nights" class="form-label">Nights</label>
                <input type="number" name="nights" id="nights" class="form-control" min="1" value="{{ old('nights', $package->nights ?? 1) }}" required>
            </div>

            {{-- Hotel Total --}}
            <div class="mb-3">
                <label for="hotel_total_price" class="form-label">Hotel Total ($)</label>
                <input type="number" name="hotel_total_price" id="hotel_total_price" class="form-control" readonly>
            </div>

            {{-- Extra & Transport --}}
            <div class="mb-3">
                <label for="extra_cost" class="form-label">Extra Cost ($)</label>
                <input type="number" name="extra_cost" id="extra_cost" class="form-control" step="0.01" value="{{ old('extra_cost', $package->extra_cost ?? 0) }}">
            </div>
            <div class="mb-3">
                <label for="transport_cost" class="form-label">Transport Cost ($)</label>
                <input type="number" name="transport_cost" id="transport_cost" class="form-control" step="0.01" value="{{ old('transport_cost', $package->transport_cost ?? 0) }}">
            </div>

            {{-- Dates --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date', $package->start_date ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date', $package->end_date ?? '') }}" required>
                </div>
            </div>

            {{-- Base & Grand Total --}}
            <div class="mb-3">
                <label for="base_price" class="form-label">Base Price ($)</label>
                <input type="number" name="base_price" id="base_price" class="form-control" step="0.01" value="{{ old('base_price', $package->base_price ?? 0) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Grand Total ($)</label>
                <input type="text" id="grand_total" class="form-control" readonly>
            </div>

            <button type="submit" class="btn btn-success mt-3">{{ isset($package) ? 'Update Package' : 'Create Package' }}</button>
        </form>
    </div>

    {{-- Packages Table --}}
    {{-- (same as before, kept unchanged) --}}
</div>

{{-- JS --}}
<script>
    const hotelSelect = document.getElementById('hotel-select');
    const roomSelect = document.getElementById('room-select');
    const nightsInput = document.getElementById('nights');
    const hotelPriceInput = document.getElementById('hotel_total_price');
    const destinationSelect = document.getElementById('destination_id');
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

    // --- Fetch Foods ---
    destinationSelect.addEventListener('change', function() {
        fetch(`/destinations/${this.value}/foods`)
            .then(res => res.json())
            .then(data => {
                foodsContainer.innerHTML = '';
                data.forEach(food => {
                    const div = document.createElement('div');
                    div.classList.add('col-md-6');
                    div.innerHTML = `
                        <div class="card p-2">
                            <label>
                                <input type="checkbox" class="food-checkbox" data-price="${food.price}" data-id="${food.id}">
                                ${food.name} (${food.menu_items}) - $${food.price}
                            </label>
                            <div class="mt-2 d-flex gap-2 align-items-center">
                                <input type="number" class="form-control food-qty" data-id="${food.id}" min="1" value="1" style="width:80px;" disabled>
                                <input type="number" class="form-control food-total" data-id="${food.id}" step="0.01" value="${food.price}" style="width:100px;" disabled>
                            </div>
                        </div>
                    `;
                    foodsContainer.appendChild(div);
                });
                attachFoodEvents();
            });
    });

    // --- Foods Calculation ---
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
@endsection
