@extends('layouts.app')

@section('title', 'Ingredients')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Ingredients</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Ingredient Inventory</h4>
                <a href="{{ route('ingredients.create') }}" class="btn btn-primary">Add Ingredient</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Current Stock</th>
                                <th>Reorder Level</th>
                                <th>Cost/Unit</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ingredients as $ingredient)
                                <tr>
                                    <td>{{ $ingredient->id }}</td>
                                    <td>{{ $ingredient->name }}</td>
                                    <td>{{ $ingredient->unit }}</td>
                                    <td>
                                        {{ number_format((float) $ingredient->current_stock, 3) }}
                                        @if((float) $ingredient->current_stock <= (float) $ingredient->reorder_level)
                                            <span class="badge badge-warning ml-2">Low</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format((float) $ingredient->reorder_level, 3) }}</td>
                                    <td>{{ number_format((float) $ingredient->cost_per_unit, 4) }}</td>
                                    <td>
                                        <span class="badge {{ $ingredient->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                            {{ ucfirst($ingredient->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('ingredients.show', $ingredient) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('ingredients.edit', $ingredient) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('ingredients.destroy', $ingredient) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this ingredient?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No ingredients found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $ingredients->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
