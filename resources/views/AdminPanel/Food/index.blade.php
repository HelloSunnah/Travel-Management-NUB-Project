@extends('master')
@section('content')
    <div class="page-inner">

<div class="container py-4">
    <h2 class="mb-4">🍴 Food Management</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create Food Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            Add New Food
        </div>
        <div class="card-body">
            <form action="{{ route('foods.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control" placeholder="Food Name" required>
                    </div>
                    <div class="col-md-3">
                        <select name="type" class="form-control" required>
                            <option value="breakfast">Breakfast</option>
                            <option value="lunch">Lunch</option>
                            <option value="dinner">Dinner</option>
                            <option value="snack">Snack</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" name="price_per_meal" class="form-control" placeholder="Price per Meal" required>
                    </div>
                    <div class="col-md-12 mt-2">
                        <textarea name="description" class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-success">Add Food</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Food List -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Food List
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Price (৳)</th>
                        <th>Description</th>
                        <th width="180px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($foods as $food)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $food->name }}</td>
                        <td>{{ ucfirst($food->type) }}</td>
                        <td>{{ number_format($food->price_per_meal, 2) }}</td>
                        <td>{{ $food->description }}</td>
                        <td>
                            <!-- Edit Button triggers Modal -->
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editFood{{ $food->id }}">
                                Edit
                            </button>
                            <form action="{{ route('foods.destroy', $food->id) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this food?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editFood{{ $food->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('foods.update', $food->id) }}" method="POST" class="modal-content">
                                @csrf @method('PUT')
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">Edit Food</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" name="name" value="{{ $food->name }}" class="form-control mb-2" required>
                                    <select name="type" class="form-control mb-2" required>
                                        <option value="breakfast" {{ $food->type == 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                                        <option value="lunch" {{ $food->type == 'lunch' ? 'selected' : '' }}>Lunch</option>
                                        <option value="dinner" {{ $food->type == 'dinner' ? 'selected' : '' }}>Dinner</option>
                                        <option value="snack" {{ $food->type == 'snack' ? 'selected' : '' }}>Snack</option>
                                    </select>
                                    <input type="number" step="0.01" name="price_per_meal" value="{{ $food->price_per_meal }}" class="form-control mb-2" required>
                                    <textarea name="description" class="form-control">{{ $food->description }}</textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
@endsection
