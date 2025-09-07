@extends('master')

@section('content')
<div class="page-inner">
    <div class="row">
        <!-- Assign Foods to Package -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Assign Foods to Package: <b>{{ $package->name }}</b></div>
                <div class="card-body">
                    <form action="{{ route('package-foods.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="package_id" value="{{ $package->id }}">

                        <div class="mb-3">
                            <label class="form-label">Select Food</label>
                            <select name="food_id" class="form-select" required>
                                <option value="">-- Select Food --</option>
                                @foreach ($foods as $food)
                                    <option value="{{ $food->id }}">
                                        {{ $food->name }} ({{ ucfirst($food->type) }}) - ${{ $food->price_per_meal }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                        </div>

                        <button class="btn btn-success w-100">Add Food</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- List of Package Foods -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Foods in {{ $package->name }}</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Food</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packageFoods as $pf)
                                <tr>
                                    <td>{{ $pf->food->name }}</td>
                                    <td>{{ ucfirst($pf->food->type) }}</td>
                                    <td>{{ $pf->quantity }}</td>
                                    <td>${{ number_format($pf->total_price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('package-foods.destroy', $pf->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Remove this food?')">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($packageFoods->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">No Foods Assigned Yet</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
