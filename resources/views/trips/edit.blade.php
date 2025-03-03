@extends('layout')

@section('content')
<div class="container">
    <h2>Edit Trip</h2>
    <form action="{{ route('trips.update', $trip->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">From</label>
            <input type="text" name="from" class="form-control" value="{{ $trip->from }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">To</label>
            <input type="text" name="to" class="form-control" value="{{ $trip->to }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Departure Date</label>
            <input type="date" name="departure_date" class="form-control" value="{{ $trip->departure_date }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Arrival Date</label>
            <input type="date" name="arrival_date" class="form-control" value="{{ $trip->arrival_date }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Free Weight</label>
            <input type="number" name="free_weight" class="form-control" value="{{ $trip->free_weight }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control status-select" required>
                <option value="pending" {{ $trip->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_transit" {{ $trip->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                <option value="delivered" {{ $trip->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="canceled" {{ $trip->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
            </select>
        </div>

        
        <button type="submit" class="btn btn-primary">Update Trip</button>
    </form>
</div>
@endsection
