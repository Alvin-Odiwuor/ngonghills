@extends('layouts.app')

@section('title', 'Recipe Ingredients')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Recipe Ingredients</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Recipe Ingredient Matrix</h4>
                <a href="{{ route('recipe-ingredients.create') }}" class="btn btn-primary">Add Recipe Ingredient</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Recipe</th>
                                <th>Ingredient</th>
                                <th>Quantity Required</th>
                                <th>Unit</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recipeIngredients as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ optional($item->recipe)->name ?? '-' }}</td>
                                    <td>{{ optional($item->ingredient)->name ?? '-' }}</td>
                                    <td>{{ number_format((float) $item->quantity_required, 3) }}</td>
                                    <td>{{ $item->unit }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('recipe-ingredients.show', $item) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('recipe-ingredients.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('recipe-ingredients.destroy', $item) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this recipe ingredient?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No recipe ingredients found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $recipeIngredients->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
