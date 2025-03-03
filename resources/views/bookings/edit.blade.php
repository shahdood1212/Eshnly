@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>Edit Booking Data</h2>
    <form action="{{ route('bookings.update', $booking) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Trip ID</label>
            <input type="number" name="trip_id" class="form-control @error('trip_id') is-invalid @enderror" value="{{ old('trip_id', $booking->trip_id) }}" required>
            @error('trip_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Ship ID</label>
            <input type="number" name="ship_id" class="form-control @error('ship_id') is-invalid @enderror" value="{{ old('ship_id', $booking->ship_id) }}" required>
            @error('ship_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $booking->price) }}" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="accepted" {{ old('status', $booking->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="rejected" {{ old('status', $booking->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-warning">Update Booking</button>
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
