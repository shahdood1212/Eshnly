@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Card 1: Total Books -->
        <div class="col-md-4">
            <a href="{{ route('books.index') }}" class="text-decoration-none">
                <div class="card bg-primary text-white p-3 shadow">
                    <h5>Total Books</h5>
                    <h2>{{ $totalBooks }}</h2>
                </div>
            </a>
        </div>
غثس
        <!-- Card 2: Total Price of Books -->
        <div class="col-md-4">
            <a href="{{ route('books.prices') }}" class="text-decoration-none">
                <div class="card bg-dark text-white p-3 shadow">
                    <h5>Total Price of Books</h5>
                    <h2>${{ number_format($totalPrice, 2) }}</h2>
                </div>
            </a>
        </div>

        <!-- Card 3: Average Book Price -->
        <div class="col-md-4">
            <a href="{{ route('books.averagePrice') }}" class="text-decoration-none">
                <div class="card bg-secondary text-white p-3 shadow">
                    <h5>Average Book Price</h5>
                    <h2>${{ number_format($averagePrice, 2) }}</h2>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection