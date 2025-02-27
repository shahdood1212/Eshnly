@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>Edit Shipment</h2>
    <form action="{{ route('ships.update', $ship->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">ID</label>
            <input type="text" name="id" class="form-control" value="{{ $ship->id }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Note</label>
            <input type="text" name="note" class="form-control @error('note') is-invalid @enderror" value="{{ old('note', $ship->note) }}">
            @error('note')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">From</label>
            <input type="text" name="from" class="form-control @error('from') is-invalid @enderror" value="{{ old('from', $ship->from) }}" required>
            @error('from')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">To</label>
            <input type="text" name="to" class="form-control @error('to') is-invalid @enderror" value="{{ old('to', $ship->to) }}" required>
            @error('to')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Weight</label>
            <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight', $ship->weight) }}" required>
            @error('weight')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $ship->quantity) }}" required>
            @error('quantity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror">
                <option value="pending" {{ old('status', $ship->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="shipped" {{ old('status', $ship->status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ old('status', $ship->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-warning">Update Shipment</button>
        <a href="{{ route('ships.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
