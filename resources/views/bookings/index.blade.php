@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>📌 Bookings List</h2>
           
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Trip ID</th>
                        <th>Ship ID</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->trip_id }}</td>
                            <td>{{ $booking->ship_id }}</td>
                            <td>${{ number_format($booking->price, 2) }}</td>
                            <td>
                                <span class="badge 
                                    @if($booking->status == 'pending') bg-warning
                                    @elseif($booking->status == 'accepted') bg-success
                                    @elseif($booking->status == 'rejected') bg-danger
                                    @else bg-primary
                                    @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
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
