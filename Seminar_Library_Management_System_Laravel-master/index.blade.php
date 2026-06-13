@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-md-5">
    <div class="d-md-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="font-weight-bold mb-1 text-dark">Library Inventory</h2>
            <p class="text-muted mb-0">Track and organize your seminar book collection</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('books.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm py-2">
                <i class="fas fa-plus mr-2"></i> Register New Book
            </a>
        </div>
    </div>

    <!-- Dashboard-style Stat Cards -->
    <div class="row">
        @include('stat-card', [
            'title' => 'Total Collection',
            'value' => $books->count(),
            'icon' => 'fa-book',
            'color' => 'primary'
        ])
        @include('stat-card', [
            'title' => 'Available for Loan',
            'value' => $books->where('status', 'available')->count(),
            'icon' => 'fa-check-circle',
            'color' => 'success'
        ])
        @include('stat-card', [
            'title' => 'On Loan',
            'value' => $books->where('status', 'borrowed')->count(),
            'icon' => 'fa-hand-holding',
            'color' => 'warning'
        ])
    </div>

    <!-- Books Data Table -->
    <div class="card border-0 shadow-sm rounded-lg mt-3 overflow-hidden">
        <div class="card-body p-0 border-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="px-4 py-4 border-0">Book Title</th>
                            <th class="py-3 border-0">Author</th>
                            <th class="py-3 border-0">ISBN</th>
                            <th class="py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                        <tr>
                            <td class="px-4 py-4 font-weight-bold text-dark">{{ $book->title }}</td>
                            <td class="py-4 text-secondary">{{ $book->author }}</td>
                            <td class="py-4 text-muted font-italic">{{ $book->isbn }}</td>
                            <td class="py-3">
                                <span class="badge badge-pill px-3 py-2 {{ $book->status == 'available' ? 'badge-light-success' : 'badge-light-warning' }}">
                                    {{ ucfirst($book->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-icon text-muted" data-toggle="dropdown">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                                        <a class="dropdown-item" href="{{ route('books.edit', $book->id) }}"><i class="fas fa-edit mr-2 text-primary"></i> Edit Details</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#"><i class="fas fa-trash mr-2"></i> Archive Book</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection