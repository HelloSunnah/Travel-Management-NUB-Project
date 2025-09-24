@extends('master')
@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-primary fw-bold">✏️ Edit Package</h2>

    <form action="{{ route('packages.update', $package) }}" method="POST" enctype="multipart/form-data" class="row g-4">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="col-md-6">
            <label class="form-label fw-bold">Package Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $package->title) }}" required>
        </div>

        {{-- Description --}}
        <div class="col-md-6">
            <label class="form-label fw-bold">Description</label>
            <input type="text" name="description" class="form-control" value="{{ old('description', $package->description) }}">
        </div>

        {{-- Destination --}}
        <div class="col-md-6">
            <label class="form-label fw-bold">Destination</label>
            <select name="destination_id" id="destination_id" class="form-select" required>
                <option value="">Select Destination</option>
                @foreach ($destinations as $dest)
                    <option value="{{ $dest->id }}" {{ $package->destination_id == $dest->id ? 'selected' : '' }}>
                        {{ $dest->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Hotel & Room --}}
        <div class="col-md-6">
            <label class="form-label fw-bold">Hotel</label>
            <select name="hotel_id" id="hotel-select" class="form-select" required>
                <option value="">Select Hotel</option>
                @foreach ($hotels as $hotel)
                    <option value="{{ $hotel->id }}" {{ $package->hotel_id == $hotel->id ? 'selected' : '' }}>
                        {{ $hotel->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold">Room</label>
            <select name="room_id" id="room-select" class="form-select" required>
                @foreach ($rooms as $room)
                    <option value="{{ $room->id }}" {{ $package->room_id == $room->id ? 'selected' : '' }}>
                        {{ $room->room_type }} - ${{ $room->price_per_night }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nights --}}
        <div class="col-md-3">
            <label class="form-label fw-bold">Nights</label>
            <input type="number" name="nights" value="{{ $package->nights }}" class="form-control" min="1">
        </div>

        {{-- Foods --}}
        <div class="col-12">
            <hr>
            <h5 class="fw-bold">🍽 Food Menus</h5>
            <div class="row g-3">
                @foreach ($foods as $food)
                    @php
                        $selected = $package->foods->contains($food->id);
                        $qty = $selected ? $package->foods->find($food->id)->pivot->quantity : 1;
                    @endphp
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="foods[]" value="{{ $food->id }}" {{ $selected ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $food->name }} ({{ $food->price }}$)</label>
                            <input type="number" name="food_qty[{{ $food->id }}]" min="1" value="{{ $qty }}" class="form-control mt-1" style="width:80px;">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Submit --}}
        <div class="col-12 text-end mt-3">
            <button type="submit" class="btn btn-success px-4">💾 Update Package</button>
        </div>
    </form>
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

    // --- Populate Rooms on Page Load (Edit Mode) ---
    function populateRooms(hotelId, selectedRoomId = null) {
        if(!hotelId) return;
        fetch(`/hotels/${hotelId}/rooms`)
            .then(res => res.json())
            .then(data => {
                roomSelect.innerHTML = '';
                data.forEach(room => {
                    const opt = document.createElement('option');
                    opt.value = room.id;
                    opt.dataset.price = room.price_per_night;
                    opt.text = `${room.room_type} - $${room.price_per_night}`;
                    if(selectedRoomId && selectedRoomId == room.id) opt.selected = true;
                    roomSelect.appendChild(opt);
                });
                updateHotelPrice();
            });
    }

    // --- Populate Foods on Page Load (Edit Mode) ---
    function populateFoods(destinationId, selectedFoods = []) {
        if(!destinationId) return;
        fetch(`/destinations/${destinationId}/foods`)
            .then(res => res.json())
            .then(data => {
                foodsContainer.innerHTML = '';
                data.forEach(food => {
                    const isChecked = selectedFoods.some(f => f.id == food.id);
                    const quantity = isChecked ? selectedFoods.find(f => f.id == food.id).pivot.quantity : 1;
                    const div = document.createElement('div');
                    div.classList.add('col-md-6', 'col-lg-4');
                    div.innerHTML = `
                        <div class="card shadow-sm border-0 h-100 food-card">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <label class="fw-semibold mb-2">
                                    <input type="checkbox" class="form-check-input me-2 food-checkbox" data-price="${food.price}" data-id="${food.id}" ${isChecked ? 'checked' : ''}>
                                    ${food.name}
                                </label>
                                <small class="text-muted mb-2">${food.menu_items}</small>
                                <div class="d-flex align-items-center gap-2 mt-auto">
                                    <input type="number" class="form-control form-control-sm food-qty" data-id="${food.id}" min="1" value="${quantity}" style="width:70px;" ${isChecked ? '' : 'disabled'}>
                                    <input type="number" class="form-control form-control-sm food-total text-end" data-id="${food.id}" step="0.01" value="${(food.price*quantity).toFixed(2)}" style="width:90px;" ${isChecked ? '' : 'disabled'}>
                                </div>
                                <span class="badge bg-primary mt-2">$${food.price}</span>
                            </div>
                        </div>
                    `;
                    foodsContainer.appendChild(div);
                });
                attachFoodEvents();
            });
    }

    // --- Hotel Price ---
    function updateHotelPrice() {
        const roomOption = roomSelect.selectedOptions[0];
        if (roomOption && nightsInput.value) {
            const roomPrice = parseFloat(roomOption.dataset.price) || 0;
            hotelPriceInput.value = (roomPrice * parseInt(nightsInput.value)).toFixed(2);
        } else hotelPriceInput.value = 0;
        updateGrandTotal();
    }

    // --- Attach Food Events ---
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

    // --- Event Listeners ---
    hotelSelect.addEventListener('change', function() {
        populateRooms(this.value);
    });
    roomSelect.addEventListener('change', updateHotelPrice);
    nightsInput.addEventListener('input', updateHotelPrice);
    basePriceInput.addEventListener('input', updateGrandTotal);
    extraInput.addEventListener('input', updateGrandTotal);
    transportInput.addEventListener('input', updateGrandTotal);

    destinationSelect.addEventListener('change', function() {
        populateFoods(this.value);
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
    });

    // --- Init for Edit Mode ---
    document.addEventListener('DOMContentLoaded', function() {
        const selectedHotel = '{{ $package->hotel_id ?? '' }}';
        const selectedRoom = '{{ $package->room_id ?? '' }}';
        const selectedDestination = '{{ $package->destination_id ?? '' }}';
        const selectedFoods = {!! isset($package) ? $package->foods->toJson() : '[]' !!};

        if(selectedHotel) populateRooms(selectedHotel, selectedRoom);
        if(selectedDestination) populateFoods(selectedDestination, selectedFoods);
        updateHotelPrice();
        updateGrandTotal();
    });
</script>
@endsection
