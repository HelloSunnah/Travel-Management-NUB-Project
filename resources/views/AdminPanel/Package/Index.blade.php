@extends('master')
@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">
            📦 All Travel Packages
        </h2>
        <a href="{{ route('packages.create') }}" class="btn btn-primary rounded-3 shadow-sm">
            ➕ Create New Package
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Packages Table --}}
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white fw-bold rounded-top-4">
            All Packages
        </div>
        <div class="card-body p-3">
            @if ($packages->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center shadow-sm mb-0">
                        <thead class="table-primary text-dark">
                            <tr class="align-middle">
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Destination</th>
                                <th>Hotel</th>
                                <th>Room</th>
                                <th>Nights</th>
                                <th>Hotel Per Person</th>
                                <th>Foods</th>
                                <th>Base</th>
                                <th>Extra</th>
                                <th>Transport</th>
                                <th>Grand Total</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $key => $p)
                                <tr class="align-middle">
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if ($p->image)
                                            <img src="{{ asset('storage/' . $p->image) }}" alt="Package Image"
                                                width="80" class="rounded shadow-sm border">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-primary">{{ $p->title }}</td>
                                    <td>{{ $p->description }}</td>
                                    <td><span class="badge bg-info text-white">{{ $p->destination->name ?? '-' }}</span></td>
                                    <td>{{ $p->hotel->name ?? '-' }}</td>
                                    <td>{{ $p->room->room_type ?? '-' }}</td>
                                    <td>{{ $p->nights }}</td>
                                    <td>{{ $p->hotel_total_price }}</td>
                                    <td>
                                        @forelse ($p->foods as $food)
                                            <span class="badge bg-info text-white mb-1">
                                                {{ $food->name }} x{{ $food->pivot->quantity }}
                                            </span>
                                        @empty
                                            <span class="text-muted">No Foods</span>
                                        @endforelse
                                    </td>
                                    <td>${{ number_format($p->base_price ?? 0, 2) }}</td>
                                    <td>${{ number_format($p->extra_cost ?? 0, 2) }}</td>
                                    <td>${{ number_format($p->transport_cost ?? 0, 2) }}</td>
                                    <td class="fw-bold text-white bg-primary rounded px-2">
                                        ${{ 
                                            $p->grand_total
                                       }}
                                    </td>
                                    <td>{{ $p->start_date }}</td>
                                    <td>{{ $p->end_date }}</td>
                                    <td>
                                        <a href="{{ route('packages.edit', $p) }}" 
                                           class="btn btn-sm btn-outline-primary rounded-3 mb-1 w-100">
                                           ✏️ Edit
                                        </a>
                                        <form action="{{ route('packages.destroy', $p) }}" method="POST"
                                              onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-3 w-100">🗑 Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-3">No packages found.</p>
            @endif
        </div>
    </div>

</div>
@endsection
