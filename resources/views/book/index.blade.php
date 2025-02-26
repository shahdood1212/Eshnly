@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>📚 Books List</h2>
            <a href="{{ route('books.create') }}" class="btn text-white px-4 py-2 rounded-pill shadow"
   style="background-color: #1a237e;">
    <i class="fas fa-plus me-2"></i> Add Book
</a>

        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Pages</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->pages }}</td>
                            <td>${{ number_format($book->price, 2) }}</td>
                            <td>
                                <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
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