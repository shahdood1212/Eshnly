@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Trip List</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead class="table-primary">
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Departure Date</th>
                        <th>Arrival Date</th>
                        <th>Free Weight</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($trips as $trip)                
                <tr>
                    <td>{{ $trip->From }}</td>
                    <td>{{ $trip->To }}</td>
                    <td>{{ $trip->departure_date }}</td>
                    <td>{{ $trip->arrival_date }}</td>
                    <td>{{ $trip->free_weight }} kg</td>
                            <td>
            @if(strtolower($trip->status) == 'pending')
                <span class="badge bg-warning">Pending</span>
            @elseif(strtolower($trip->status) == 'completed')
                <span class="badge bg-success">Completed</span>
            @elseif(strtolower($trip->status) == 'cancelled')
                <span class="badge bg-danger">Cancelled</span>
            @else
                <span class="badge bg-secondary">{{ ucfirst($trip->status) }}</span>
            @endif
        </td>

        <td>{{ $trip->user ? $trip->user->name : 'Unknown' }}</td>
        <td>
                        <a href="{{ route('trips.show', $trip->id) }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('trips.edit', $trip->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
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
