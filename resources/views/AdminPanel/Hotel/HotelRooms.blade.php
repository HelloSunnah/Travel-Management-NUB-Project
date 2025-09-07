@extends('master')
@section('content')
    <div class="page-inner">
<div class="container mt-5">
    <h2 class="mb-4">Hotel Rooms</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="roomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="roomForm" method="POST">
                @csrf
                <input type="hidden" id="method" name="_method" value="POST">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Hotel</label>
                            <select class="form-control" name="hotel_id" id="hotel_id" required>
                                <option value="">Select Hotel</option>
                                @foreach($hotels as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Room Type</label>
                            <input type="text" class="form-control" name="room_type" id="room_type" required>
                        </div>
                        <div class="mb-3">
                            <label>Capacity</label>
                            <input type="number" class="form-control" name="capacity" id="capacity" required>
                        </div>
                        <div class="mb-3">
                            <label>Price Per Night</label>
                            <input type="number" step="0.01" class="form-control" name="price_per_night" id="price_per_night" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">Save</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add button -->
    <button class="btn btn-primary mb-3" onclick="openCreateModal()">+ Add Room</button>

    <!-- Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hotel</th>
                <th>Type</th>
                <th>Capacity</th>
                <th>Price</th>
                <th>Description</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rooms as $room)
            <tr>
                <td>{{ $room->hotel->name }}</td>
                <td>{{ $room->room_type }}</td>
                <td>{{ $room->capacity }}</td>
                <td>{{ $room->price_per_night }}</td>
                <td>{{ $room->description }}</td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="openEditModal({{ $room }})">Edit</button>
                    <form action="{{ route('hotel-rooms.destroy', $room) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this room?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>

<script>
function openCreateModal() {
    document.getElementById('roomForm').reset();
    document.getElementById('roomForm').action = "{{ route('hotel-rooms.store') }}";
    document.getElementById('method').value = "POST";
    new bootstrap.Modal(document.getElementById('roomModal')).show();
}

function openEditModal(room) {
    document.getElementById('roomForm').action = "/hotel-rooms/" + room.id;
    document.getElementById('method').value = "PUT";
    document.getElementById('hotel_id').value = room.hotel_id;
    document.getElementById('room_type').value = room.room_type;
    document.getElementById('capacity').value = room.capacity;
    document.getElementById('price_per_night').value = room.price_per_night;
    document.getElementById('description').value = room.description ?? '';
    new bootstrap.Modal(document.getElementById('roomModal')).show();
}
</script>
@endsection
