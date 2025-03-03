@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Shipment List</h2>
            
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead class="table-primary">
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Shipment Name</th>
                        <th>Quantity</th>
                        <th>Weight</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($shipments as $ship)                <tr>
                    <td>{{ $ship->From }}</td>
                    <td>{{ $ship->To }}</td>
                    <td>{{ $ship->note }}</td>
                    <td>{{ $ship->quantity }}</td>
                    <td>{{ $ship->weight }}</td>
                    <td>
                        @if($ship->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($ship->status == 'in_transit')
                            <span class="badge bg-primary">in transit</span>
                        @elseif($ship->status == 'delivered')
                            <span class="badge bg-success">Delivered</span>
                        @endif
                    </td>
                    <td>
                        @if($ship->image)
                            <img src="{{ asset('storage/' . $ship->image) }}" 
                                 alt="{{ $ship->shipment_name }}" 
                                 class="img-fluid rounded shadow" 
                                 style="max-width: 100px;">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('ships.show', $ship->id) }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('ships.edit', $ship->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('ships.destroy', $ship->id) }}" method="POST" style="display:inline;">
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