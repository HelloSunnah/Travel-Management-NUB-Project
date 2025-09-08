@extends('master')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Travel Packages Management</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Package Form (Create / Edit) --}}
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
                    @foreach($destinations as $dest)
                        <option value="{{ $dest->id }}" {{ (old('destination_id', $package->destination_id ?? '') == $dest->id) ? 'selected' : '' }}>
                            {{ $dest->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Foods (Dynamic by destination) --}}
            <h5 class="mt-3">Food Menus</h5>
            <div class="row g-2 foods-container">
                @if(isset($package))
                    @foreach($package->foods as $food)
                        <div class="col-md-6">
                            <div class="card p-2">
                                <label class="form-check-label">
                                    <input type="checkbox" name="foods[{{ $food->food->id }}][food_id]" value="{{ $food->food->id }}" checked class="form-check-input me-2">
                                    {{ $food->food->name }} - ${{ $food->food->price }}
                                </label>
                                <div class="mt-2 d-flex gap-2 align-items-center">
                                    <input type="number" name="foods[{{ $food->food->id }}][quantity]" class="form-control" style="width:80px;" min="1" value="{{ $food->quantity }}">
                                    <input type="number" name="foods[{{ $food->food->id }}][total_price]" class="form-control" style="width:100px;" step="0.01" value="{{ $food->total_price }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Hotel --}}
            <div class="mb-3 mt-3">
                <label for="hotel-select" class="form-label">Hotel</label>
                <select name="hotel_id" id="hotel-select" class="form-select" required>
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
                <select name="room_id" id="room-select" class="form-select" required>
                    @if(isset($package))
                        @foreach($package->hotel->rooms as $room)
                            <option value="{{ $room->id }}" {{ ($package->room_id == $room->id) ? 'selected' : '' }}>
                                {{ $room->room_type }} - ${{ $room->price_per_night }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            {{-- Nights --}}
            <div class="mb-3">
                <label for="nights" class="form-label">Nights</label>
                <input type="number" name="nights" id="nights" class="form-control" min="1" value="{{ old('nights', $package->nights ?? 1) }}" required>
            </div>

            {{-- Hotel Total --}}
            <div class="mb-3">
                <label for="hotel_total_price" class="form-label">Hotel Total Price ($)</label>
                <input type="number" name="hotel_total_price" id="hotel_total_price" class="form-control" step="0.01" value="{{ old('hotel_total_price', $package->hotel_total_price ?? 0) }}" readonly>
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

            {{-- Base Price --}}
            <div class="mb-3">
                <label for="base_price" class="form-label">Base Price ($)</label>
                <input type="number" name="base_price" id="base_price" class="form-control" step="0.01" value="{{ old('base_price', $package->base_price ?? 0) }}">
            </div>

            <button type="submit" class="btn btn-success mt-3">{{ isset($package) ? 'Update Package' : 'Create Package' }}</button>
        </form>
    </div>

    {{-- Packages Table --}}
    <div class="card p-4">
        <h4 class="mb-3">All Packages</h4>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Destination</th>
                        <th>Foods</th>
                        <th>Hotel</th>
                        <th>Room</th>
                        <th>Nights</th>
                        <th>Hotel Total</th>
                        <th>Extra Cost</th>
                        <th>Transport Cost</th>
                        <th>Grand Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packages as $package)
                        <tr>
                            <td>{{ $package->title }}</td>
                            <td>{{ $package->destination->name }}</td>
                            <td>
                                <ul class="mb-0 ps-3">
                                    @foreach($package->foods as $food)
                                        <li>{{ $food->food->name }} ({{ $food->quantity }} x ${{ $food->food->price }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $package->hotel->name }}</td>
                            <td>{{ $package->room->room_type }}</td>
                            <td>{{ $package->nights }}</td>
                            <td>${{ $package->hotel_total_price }}</td>
                            <td>${{ $package->extra_cost ?? 0 }}</td>
                            <td>${{ $package->transport_cost ?? 0 }}</td>
                            <td>${{
                                $package->hotel_total_price +
                                $package->foods->sum('total_price') +
                                $package->base_price +
                                ($package->extra_cost ?? 0) +
                                ($package->transport_cost ?? 0)
                            }}</td>
                            <td>
                                <a href="{{ route('packages.edit', $package) }}" class="btn btn-sm btn-primary mb-1">Edit</a>
                                <form action="{{ route('packages.destroy', $package) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- JS for dynamic hotel → room & destination → foods --}}
<script>
    const hotelSelect = document.getElementById('hotel-select');
    const roomSelect = document.getElementById('room-select');
    const nightsInput = document.getElementById('nights');
    const hotelPriceInput = document.getElementById('hotel_total_price');

    function updateHotelPrice() {
        const roomOption = roomSelect.selectedOptions[0];
        if(roomOption && nightsInput.value){
            const roomPrice = parseFloat(roomOption.text.split('$')[1]) || 0;
            hotelPriceInput.value = (roomPrice * parseInt(nightsInput.value)).toFixed(2);
        }
    }

    hotelSelect.addEventListener('change', function () {
        fetch(`/hotels/${this.value}/rooms`)
            .then(res => res.json())
            .then(data => {
                roomSelect.innerHTML = '';
                data.forEach(room => {
                    const opt = document.createElement('option');
                    opt.value = room.id;
                    opt.text = `${room.room_type} - $${room.price_per_night}`;
                    roomSelect.appendChild(opt);
                });
                updateHotelPrice();
            });
    });

    roomSelect.addEventListener('change', updateHotelPrice);
    nightsInput.addEventListener('input', updateHotelPrice);
    updateHotelPrice();

    // Destination → Foods
    const destinationSelect = document.getElementById('destination_id');
    const foodsContainer = document.querySelector('.foods-container');

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
                                <input type="checkbox" name="foods[${food.id}][food_id]" value="${food.id}">
                                ${food.name} (${food.menu_items}) - $${food.price}
                            </label>
                            <div class="mt-2 d-flex gap-2 align-items-center">
                                <input type="number" name="foods[${food.id}][quantity]" class="form-control" style="width:80px;" min="1" value="1">
                                <input type="number" step="0.01" name="foods[${food.id}][total_price]" class="form-control" style="width:100px;" value="${food.price}">
                            </div>
                        </div>
                    `;
                    foodsContainer.appendChild(div);
                });
            });
    });
</script>
@endsection
