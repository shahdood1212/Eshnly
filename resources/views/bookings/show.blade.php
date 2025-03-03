@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4">
        <h2 class="mb-3">Booking Details</h2>

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $booking->id }}</td>
            </tr>
            <tr>
                <th>Trip ID</th>
                <td>{{ $booking->trip_id }}</td>
            </tr>
            <tr>
                <th>Ship ID</th>
                <td>{{ $booking->ship_id }}</td>
            </tr>
            <tr>
                <th>Price</th>
                <td>{{ number_format($booking->price, 2) }} USD</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($booking->status) }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $booking->created_at ? $booking->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $booking->updated_at ? $booking->updated_at->format('Y-m-d H:i') : 'N/A' }}</td>
            </tr>
        </table>

        <a href="{{ route('bookings.index') }}" class="btn btn-primary mt-3">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>
@endsection
