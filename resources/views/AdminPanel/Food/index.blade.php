@extends('master')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Manage Food Menus</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Food Form --}}
    <div class="card mb-5 p-4">
        <h4 class="mb-3">{{ isset($editFood) ? 'Edit Food Menu' : 'Add Food Menu' }}</h4>
        <form action="{{ isset($editFood) ? route('foods.update', $editFood) : route('foods.store') }}" method="POST">
            @csrf
            @if(isset($editFood)) @method('PUT') @endif

            <div class="mb-3">
                <label for="name" class="form-label">Food Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter food name"
                       value="{{ old('name', $editFood->name ?? '') }}" required>
            </div><div class="mb-3">
    <label for="destination_id" class="form-label">Destination</label>
    <select id="destination_id" name="destination_id" class="form-control" required>
        <option value="">Select Destination</option>
        @foreach($destinations as $destination)
            <option value="{{ $destination->id }}"
                {{ old('destination_id', $editFood->destination_id ?? '') == $destination->id ? 'selected' : '' }}>
                {{ $destination->name }}
            </option>
        @endforeach
    </select>
</div>


            <div class="mb-3">
                <label for="menu_items" class="form-label">Menu Items</label>
                <textarea id="menu_items" name="menu_items" class="form-control" placeholder="E.g., Rice + Chicken + Salad" rows="3" required>{{ old('menu_items', $editFood->menu_items ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price (TK)</label>
                <input type="number" step="0.01" id="price" name="price" class="form-control"
                       value="{{ old('price', $editFood->price ?? '') }}" required>
            </div>

            <button type="submit" class="btn btn-success">
                {{ isset($editFood) ? 'Update Food' : 'Add Food' }}
            </button>
            @if(isset($editFood))
                <a href="{{ route('foods.index') }}" class="btn btn-secondary">Cancel</a>
            @endif
        </form>
    </div>

    {{-- Foods Table --}}
    <div class="card p-4">
        <h4 class="mb-3">All Food Menus</h4>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Destination</th>
                        <th>Menu Items</th>
                        <th>Price (TK)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
          <tbody>
    @foreach($foods as $food)
        <tr>
            <td>{{ $food->name }}</td>
            <td>{{ $food->destination->name ?? 'N/A' }}</td>
            <td>{{ $food->menu_items }}</td>
            <td>{{ $food->price }}</td>
            <td>
                <a href="{{ route('foods.index', ['editFood' => $food->id]) }}" class="btn btn-sm btn-primary mb-1">Edit</a>
                <form action="{{ route('foods.destroy', $food) }}" method="POST" style="display:inline-block;">
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
@endsection
