@extends('master')
@section('content')

<div class="row">
    <!-- Package Form -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">{{ isset($editPackage) ? 'Edit Package' : 'Add Package' }}</div>
            <div class="card-body">
                <form action="{{ isset($editPackage) ? route('packages.update', $editPackage->id) : route('packages.store') }}" method="POST">
                    @csrf
                    @if(isset($editPackage)) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label">Package Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $editPackage->name ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control">{{ old('description', $editPackage->description ?? '') }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Days</label>
                            <input type="number" name="days" class="form-control" value="{{ old('days', $editPackage->days ?? 1) }}">
                        </div>
                        <div class="col">
                            <label class="form-label">Nights</label>
                            <input type="number" name="nights" class="form-control" value="{{ old('nights', $editPackage->nights ?? 1) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Benefit Type</label>
                            <select name="benefit_type" class="form-select">
                                <option value="fixed" {{ (old('benefit_type', $editPackage->benefit_type ?? '')=='fixed')?'selected':'' }}>Fixed</option>
                                <option value="percent" {{ (old('benefit_type', $editPackage->benefit_type ?? '')=='percent')?'selected':'' }}>Percent</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Benefit Value</label>
                            <input type="number" name="benefit_value" class="form-control" value="{{ old('benefit_value', $editPackage->benefit_value ?? 0) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ (old('status', $editPackage->status ?? '')=='active')?'selected':'' }}>Active</option>
                            <option value="inactive" {{ (old('status', $editPackage->status ?? '')=='inactive')?'selected':'' }}>Inactive</option>
                        </select>
                    </div>

                    <button class="btn btn-success w-100">{{ isset($editPackage) ? 'Update Package' : 'Save Package' }}</button>
                    @if(isset($editPackage))
                        <a href="{{ route('packages.index') }}" class="btn btn-secondary w-100 mt-2">Cancel Edit</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Package List -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Packages List</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Days/Nights</th>
                            <th>Total Cost</th>
                            <th>Final Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $package)
                        <tr>
                            <td>{{ $package->name }}</td>
                            <td>{{ $package->days }}/{{ $package->nights }}</td>
                            <td>${{ $package->total_cost }}</td>
                            <td>${{ $package->final_price }}</td>
                            <td>{{ ucfirst($package->status) }}</td>
                            <td>
                                <a href="{{ route('packages.index', ['edit'=>$package->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('packages.destroy',$package->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this package?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($packages->isEmpty())
                        <tr><td colspan="6" class="text-center">No Packages Found</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
