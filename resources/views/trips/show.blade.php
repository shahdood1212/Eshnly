@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4">
        <h2 class="mb-3">Trip Details</h2>

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $trip->id }}</td>
            </tr>
            <tr>
            <th>From</th>
            <td>{{ $trip->from }}</td>
        </tr>
        <tr>
            <th>To</th>
            <td>{{ $trip->to }}</td>
        </tr>

            <tr>
                <th>Departure Date</th>
                <td>{{ $trip->departure_date }}</td>
            </tr>
            <tr>
                <th>Arrival Date</th>
                <td>{{ $trip->arrival_date }}</td>
            </tr>
            <tr>
                <th>Free Weight</th>
                <td>{{ $trip->free_weight }} kg</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($trip->status) }}</td>
            </tr>
            <tr>
                <th>Created By</th>
                <td>{{ $trip->createdBy->name ?? 'Unknown' }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $trip->created_at ? $trip->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $trip->updated_at ? $trip->updated_at->format('Y-m-d H:i') : 'N/A' }}</td>
            </tr>
        </table>

        <a href="{{ route('trips.index') }}" class="btn btn-primary mt-3">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>
@endsection
