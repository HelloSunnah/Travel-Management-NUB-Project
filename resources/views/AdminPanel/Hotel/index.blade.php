@extends('master')
@section('content')
    <div class="page-inner">

        <div class="container mt-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Hotel Management</h4>
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#hotelModal"
                        onclick="openCreateForm()">+ Add Hotel</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Rating</th>
                                <th>Description</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hotels as $hotel)
                                <tr>
                                    <td>{{ $hotel->id }}</td>
                                    <td>{{ $hotel->name }}</td>
                                    <td>{{ $hotel->destination->name ?? '-' }}</td>
                                    <td>{{ $hotel->rating ?? '-' }}</td>
                                    <td>{{ $hotel->description ?? '-' }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#hotelModal"
                                            onclick="openEditForm({{ $hotel }})">Edit</button>
                                        <form action="{{ route('hotels.destroy', $hotel->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this hotel?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No Hotels Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal for Create/Edit -->
        <div class="modal fade" id="hotelModal" tabindex="-1" aria-labelledby="hotelModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="hotelForm" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="hotelModalLabel">Add Hotel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Hotel Name</label>
                                <input type="text" name="name" id="hotelName" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <select name="destination_id" id="hotelLocation" class="form-select" required>
                                    <option value="">-- Select Location --</option>
                                    @foreach ($location as $loc)
                                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Rating (1-5)</label>
                                <input type="number" name="rating" id="hotelRating" class="form-control" min="1"
                                    max="5">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="hotelDescription" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Save Hotel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openCreateForm() {
            document.getElementById('hotelForm').action = "{{ route('hotels.store') }}";
            document.getElementById('formMethod').value = "POST";
            document.getElementById('hotelModalLabel').innerText = "Add Hotel";
            document.getElementById('hotelName').value = '';
            document.getElementById('hotelLocation').value = '';
            document.getElementById('hotelRating').value = '';
            document.getElementById('hotelDescription').value = '';
        }

        function openEditForm(hotel) {
            document.getElementById('hotelForm').action = "/hotels/" + hotel.id;
            document.getElementById('formMethod').value = "PUT";
            document.getElementById('hotelModalLabel').innerText = "Edit Hotel";
            document.getElementById('hotelName').value = hotel.name;
            document.getElementById('hotelLocation').value = hotel.destination_id; // dropdown selection
            document.getElementById('hotelRating').value = hotel.rating ?? '';
            document.getElementById('hotelDescription').value = hotel.description ?? '';
        }
    </script>
@endsection
