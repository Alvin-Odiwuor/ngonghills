@extends('layouts.app')

@section('title', 'Recipes')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Recipes</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Product Recipes</h4>
                <a href="{{ route('recipes.create') }}" class="btn btn-primary">Add Recipe</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Product</th>
                                <th>Yield Quantity</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recipes as $recipe)
                                <tr>
                                    <td>{{ $recipe->id }}</td>
                                    <td>{{ $recipe->name }}</td>
                                    <td>{{ optional($recipe->product)->product_name ?? '-' }}</td>
                                    <td>{{ number_format((float) $recipe->yield_quantity, 3) }}</td>
                                    <td>
                                        <span class="badge {{ $recipe->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                            {{ ucfirst($recipe->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this recipe?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No recipes found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $recipes->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
