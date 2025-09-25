@extends('master')
@section('content')
    <div class="page-inner">
        <div class="container mt-5">
            <h2 class="mb-4">Destinations</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Add/Edit Modal -->
            <div class="modal fade" id="destinationModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="destinationForm" method="POST">
                        @csrf
                        <input type="hidden" id="method" name="_method" value="POST">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Destination</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label>Country</label>
                                    <input type="text" class="form-control" name="country" id="country">
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

            <div class="container mt-4">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Destination Management</h4>
                        <button class="btn btn-success mb-3" onclick="openCreateModal()">+ Add New Location</button>

                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Country</th>
                                    <th>Description</th>
                                    <th width="180">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($destinations as $index => $dest)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $dest->name }}</td>
                                        <td>{{ $dest->country ?? '-' }}</td>
                                        <td>{{ $dest->description ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info"
                                                onclick="openEditModal({{ $dest }})">Edit</button>
                                            <form action="{{ route('destinations.destroy', $dest) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this destination?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('destinationForm').reset();
            document.getElementById('destinationForm').action = "{{ route('destinations.store') }}";
            document.getElementById('method').value = "POST";
            new bootstrap.Modal(document.getElementById('destinationModal')).show();
        }

        function openEditModal(dest) {
            document.getElementById('destinationForm').action = "/destinations/" + dest.id;
            document.getElementById('method').value = "PUT";
            document.getElementById('name').value = dest.name;
            document.getElementById('country').value = dest.country ?? '';
            document.getElementById('description').value = dest.description ?? '';
            new bootstrap.Modal(document.getElementById('destinationModal')).show();
        }
    </script>
@endsection
