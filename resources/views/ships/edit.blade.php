@extends('layout')

@section('content')
<div class="container">
    <h2>Edit Shipment</h2>
    <form action="{{ route('ships.update', $ship->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">From</label>
            <input type="text" name="from" class="form-control" value="{{ old('from', $ship->from) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">To</label>
            <input type="text" name="to" class="form-control" value="{{ old('to', $ship->to) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Weight</label>
            <input type="number" name="weight" class="form-control" value="{{ old('weight', $ship->weight) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $ship->quantity) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $ship->price) }}" required>
        </div>

        <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-control status-select" required>
        <option value="pending" {{ $ship->status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="in_transit" {{ $ship->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
        <option value="delivered" {{ $ship->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
        <option value="canceled" {{ $ship->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
    </select>
</div>

        <div class="mb-3">
            <label class="form-label">Note</label>
            <textarea name="note" class="form-control">{{ old('note', $ship->note) }}</textarea>
        </div>

        @if($ship->image)
            <div class="mb-3">
                <label class="form-label">Current Image</label>
                <br>
                <img src="{{ asset('storage/' . $ship->image) }}" width="150" class="img-thumbnail">
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Upload New Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Shipment</button>
    </form>
</div>
@endsection
